<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Check if admin user exists, create if not
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        // Check if Event Organizer (EO) user exists, create if not
        if (!User::where('email', 'eo@example.com')->exists()) {
            User::create([
                'name' => 'Event Organizer',
                'email' => 'eo@example.com',
                'password' => Hash::make('password'),
                'role' => 'eo',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        // Check if regular user exists, create if not
        if (!User::where('email', 'user@example.com')->exists()) {
            User::create([
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        // Set up image directories
        $this->call(ImageDirectoriesSeeder::class);

        // Seed categories
        $this->call(CategorySeeder::class);

        // Seed concerts/events
        $this->call([
            EventSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
