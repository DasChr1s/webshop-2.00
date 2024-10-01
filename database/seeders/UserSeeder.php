<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Für Passwort-Hashing
use App\Models\User; // Stelle sicher, dass du das User Modell importierst

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin-Benutzer erstellen
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'), // Passwort-Hashing
            'is_admin' => true, // Admin-Flag
        ]);

        // Normaler Benutzer erstellen
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'), // Passwort-Hashing
            'is_admin' => false, // Kein Admin-Flag
        ]);
    }
}
