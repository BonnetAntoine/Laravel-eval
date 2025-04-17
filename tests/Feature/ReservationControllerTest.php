<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_reservation()
    {
        // Créer un utilisateur et se connecter
        $user = User::factory()->create();
        $this->actingAs($user);

        // Créer une salle
        $room = Room::factory()->create();

        // Essayer de créer une réservation
        $response = $this->post(route('reservations.store'), [
            'room_id' => $room->id,
            'reservation_date' => Carbon::today()->format('Y-m-d'),
            'debut' => '10:00',
            'fin' => '12:00',
            'titre' => 'Réunion',
            'description' => 'Réunion importante',
        ]);

        // Vérifier que la réservation a été enregistrée
        $response->assertRedirect(route('reservations.index'));
        $this->assertDatabaseHas('reservations', [
            'room_id' => $room->id,
            'user_id' => $user->id,
            'titre' => 'Réunion',
        ]);
    }

    public function test_create_reservation_conflict()
    {
        // Créer un utilisateur et se connecter
        $user = User::factory()->create();
        $this->actingAs($user);

        // Créer une salle
        $room = Room::factory()->create();

        // Créer une première réservation
        Reservation::create([
            'room_id' => $room->id,
            'user_id' => $user->id,
            'debut' => Carbon::today()->addHours(9),
            'fin' => Carbon::today()->addHours(11),
            'titre' => 'Réunion 1',
        ]);

        // Essayer de créer une réservation qui entre en conflit
        $response = $this->post(route('reservations.store'), [
            'room_id' => $room->id,
            'reservation_date' => Carbon::today()->format('Y-m-d'),
            'debut' => '10:00',
            'fin' => '12:00',
            'titre' => 'Réunion 2',
            'description' => 'Réunion conflictuelle',
        ]);

        // Vérifier que l'erreur de conflit est renvoyée
        $response->assertSessionHasErrors(['debut' => 'La salle est déjà réservée pendant cette plage horaire.']);
    }

    public function test_cancel_reservation()
    {
        // Créer un utilisateur et se connecter
        $user = User::factory()->create();
        $this->actingAs($user);

        // Créer une réservation
        $reservation = Reservation::create([
            'room_id' => Room::factory()->create()->id,
            'user_id' => $user->id,
            'debut' => Carbon::today()->addHours(9),
            'fin' => Carbon::today()->addHours(11),
            'titre' => 'Réunion',
        ]);

        // Annuler la réservation
        $response = $this->post(route('reservations.cancel', $reservation));

        // Vérifier que la réservation est annulée
        $response->assertRedirect(route('reservations.index'));
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'is_cancelled' => true,
        ]);
    }

    public function test_access_forbidden_for_non_admin()
    {
        // Créer un utilisateur non admin
        $user = User::factory()->create();
        $this->actingAs($user);

        // Essayer d'accéder à la page des réservations par salle
        $response = $this->get(route('reservations.by-room'));
        $response->assertRedirect(route('reservations.index'));
        $response->assertSessionHas('error', 'Accès non autorisé.');
    }

    public function test_admin_access_to_reservations_by_room()
    {
        // Créer un utilisateur admin
        $admin = User::factory()->create();

        // Assurez-vous que vous avez un rôle admin configuré
        // On va assumer que le rôle admin existe. Si nécessaire, créez un rôle admin ici.
        $admin->assignRole('admin'); // Vérifier que le rôle admin existe bien dans votre base de données.

        // Créer une salle
        $room = Room::factory()->create();

        // Créer une réservation associée à la salle et à l'admin
        $reservation = Reservation::create([
            'room_id' => $room->id,
            'user_id' => $admin->id,
            'debut' => Carbon::today()->addHours(9),
            'fin' => Carbon::today()->addHours(11),
            'titre' => 'Réunion',
        ]);

        // Se connecter en tant qu'administrateur
        $this->actingAs($admin);

        // Vérifier l'accès à la page des réservations par salle
        $response = $this->get(route('reservations.by-room'));

        // Vérifier que la requête a retourné un statut 200 (OK)
        $response->assertStatus(200);

        // Vérifier que la réservation créée est bien présente dans la page (sur la base du titre)
        $response->assertSee($reservation->titre);

        // Vérifier que la réservation apparait bien pour la salle spécifique
        $response->assertSee($room->name); // Assurez-vous que la salle a un attribut 'name' que vous pouvez vérifier dans la vue.
    }

}


