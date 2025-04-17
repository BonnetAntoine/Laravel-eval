<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Silber\Bouncer\BouncerFacade as Bouncer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'first_name' => 'user',
            'last_name' => 'test',
            'email' => 'usertest@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        Bouncer::assign('user')->to($user);

        $admin = User::firstOrCreate([
            'first_name' => 'test',
            'last_name' => 'admin',
            'email' => 'testadmin@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        Bouncer::assign('admin')->to($admin);

        // call seeders here
        $this->call([

        ]);
    }
}
