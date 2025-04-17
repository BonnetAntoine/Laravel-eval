<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\DashboardController;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\View\View;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $admin;
    protected $employee;
    protected $rooms;

    public function setUp(): void
    {
        parent::setUp();

        // Créer un admin et un employé
        $this->admin = User::factory()->create();
        $this->admin->role = 'admin'; // Supposant une colonne 'role' pour définir les autorisations
        $this->admin->save();

        $this->employee = User::factory()->create();
        $this->employee->role = 'employee';
        $this->employee->save();

        // Créer quelques salles
        $this->rooms = Room::factory()->count(3)->create();

        // Créer des réservations futures et passées pour l'employé
        $futureReservations = [];
        $pastReservations = [];

        for ($i = 1; $i <= 3; $i++) {
            $futureReservations[] = Reservation::factory()->create([
                'user_id' => $this->employee->id,
                'room_id' => $this->rooms->random()->id,
                'debut' => Carbon::now()->addDays($i),
                'fin' => Carbon::now()->addDays($i)->addHours(1),
                'is_cancelled' => false
            ]);

            $pastReservations[] = Reservation::factory()->create([
                'user_id' => $this->employee->id,
                'room_id' => $this->rooms->random()->id,
                'debut' => Carbon::now()->subDays($i),
                'fin' => Carbon::now()->subDays($i)->addHours(1),
                'is_cancelled' => false
            ]);
        }

        // Créer quelques réservations pour aujourd'hui
        Reservation::factory()->create([
            'room_id' => $this->rooms->first()->id,
            'debut' => Carbon::today()->addHours(10),
            'fin' => Carbon::today()->addHours(11),
            'is_cancelled' => false
        ]);

        Reservation::factory()->create([
            'room_id' => $this->rooms->last()->id,
            'debut' => Carbon::today()->addHours(14),
            'fin' => Carbon::today()->addHours(15),
            'is_cancelled' => false
        ]);
    }

    /**
     * @test
     * @group dashboard
     */
    public function admin_sees_admin_dashboard()
    {
        // Simuler une connexion en tant qu'admin
        $this->actingAs($this->admin);

        // Intercepter la création de vue
        $this->expectViewIs('dashboard');

        // Vérifier que certaines variables sont passées à la vue
        $this->expectViewHas(['totalRooms', 'totalUsers', 'totalReservations', 'rooms', 'todayReservations']);

        // Appeler la méthode index
        $controller = new DashboardController();
        $response = $controller->index();

        // Assertions supplémentaires sur l'objet de vue
        $viewData = $response->getData();
        $this->assertEquals(Room::count(), $viewData['totalRooms']);
        $this->assertEquals(User::count(), $viewData['totalUsers']);
        $this->assertEquals(Reservation::count(), $viewData['totalReservations']);
        $this->assertArrayHasKey('reservationsByDay', $viewData);
    }

    /**
     * @test
     * @group dashboard
     */
    public function employee_sees_employee_dashboard()
    {
        // Simuler une connexion en tant qu'employé
        $this->actingAs($this->employee);

        // Intercepter la création de vue
        $this->expectViewIs('dashboard');

        // Vérifier que certaines variables sont passées à la vue
        $this->expectViewHas(['upcomingReservations', 'pastReservations', 'rooms', 'today']);

        // Appeler la méthode index
        $controller = new DashboardController();
        $response = $controller->index();

        // Assertions supplémentaires sur l'objet de vue
        $viewData = $response->getData();
        $this->assertNotNull($viewData['upcomingReservations']);
        $this->assertNotNull($viewData['pastReservations']);
        $this->assertCount(3, $viewData['rooms']);
        $this->assertEquals(Carbon::today()->toDateString(), $viewData['today']->toDateString());
    }

    /**
     * @test
     * @group dashboard
     */
    public function admin_dashboard_has_correct_statistics()
    {
        $this->actingAs($this->admin);

        $controller = new DashboardController();

        // Accéder à la méthode privée à l'aide de la réflexion
        $reflector = new \ReflectionClass($controller);
        $method = $reflector->getMethod('adminDashboard');
        $method->setAccessible(true);

        $response = $method->invoke($controller);
        $viewData = $response->getData();

        // Vérifier que les statistiques sont correctes
        $this->assertEquals(Room::count(), $viewData['totalRooms']);
        $this->assertEquals(User::count(), $viewData['totalUsers']);
        $this->assertEquals(Reservation::count(), $viewData['totalReservations']);

        // Vérifier les réservations d'aujourd'hui
        $this->assertCount(2, $viewData['todayReservations']);

        // Vérifier que les réservations sont triées par heure de début
        $reservations = $viewData['todayReservations'];
        $this->assertTrue($reservations[0]->debut->lt($reservations[1]->debut));
    }

    /**
     * @test
     * @group dashboard
     */
    public function employee_dashboard_shows_correct_reservations()
    {
        $this->actingAs($this->employee);

        $controller = new DashboardController();

        // Accéder à la méthode privée à l'aide de la réflexion
        $reflector = new \ReflectionClass($controller);
        $method = $reflector->getMethod('employeeDashboard');
        $method->setAccessible(true);

        $response = $method->invoke($controller);
        $viewData = $response->getData();

        // Vérifier que l'employé voit ses propres réservations
        $this->assertCount(3, $viewData['upcomingReservations']);
        $this->assertCount(3, $viewData['pastReservations']);

        // Vérifier que les réservations appartiennent bien à l'employé connecté
        foreach ($viewData['upcomingReservations'] as $reservation) {
            $this->assertEquals($this->employee->id, $reservation->user_id);
        }

        // Vérifier que les réservations passées sont triées par ordre décroissant
        $pastReservations = $viewData['pastReservations'];
        $this->assertTrue($pastReservations[0]->debut->gt($pastReservations[1]->debut));
    }

    /**
     * @test
     * @group dashboard
     */
    public function isA_method_determines_correct_dashboard_type()
    {
        // Simuler l'existence de la méthode isA (adapter selon votre implémentation)
        User::macro('isA', function ($role) {
            return $this->role === $role;
        });

        // Test pour admin
        $this->actingAs($this->admin);
        $this->assertTrue($this->admin->isA('admin'));

        $controller = app()->make(DashboardController::class);
        $response = $controller->index();

        // Vérifier que les données spécifiques à l'admin sont présentes
        $viewData = $response->getData();
        $this->assertArrayHasKey('totalReservations', $viewData);

        // Test pour employé
        $this->actingAs($this->employee);
        $this->assertFalse($this->employee->isA('admin'));

        $controller = app()->make(DashboardController::class);
        $response = $controller->index();

        // Vérifier que les données spécifiques à l'employé sont présentes
        $viewData = $response->getData();
        $this->assertArrayHasKey('upcomingReservations', $viewData);
    }
}
