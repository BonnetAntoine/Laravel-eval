<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des rôles
        Bouncer::role()->firstOrCreate([
            'nom' => 'admin',
            'titre' => 'Administrateur',
        ]);

        Bouncer::role()->firstOrCreate([
            'nom' => 'employee',
            'titre' => 'Employé',
        ]);

        // Définir les permissions pour les administrateurs
        Bouncer::allow('admin')->to('manage-rooms');
        Bouncer::allow('admin')->to('view-dashboard');

        // Définir les permissions pour les employés
        Bouncer::allow('employee')->to('make-reservations');
        Bouncer::allow('employee')->to('view-own-reservations');
    }
}
