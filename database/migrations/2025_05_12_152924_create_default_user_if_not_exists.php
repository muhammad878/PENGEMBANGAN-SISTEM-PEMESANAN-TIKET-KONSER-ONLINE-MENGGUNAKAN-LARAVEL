<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if user with ID 1 exists
        if (!User::find(1)) {
            // Create default admin user
            User::create([
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@konserkuy.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]);
        }

        // Ensures at least one user with organizer role exists
        if (!User::where('role', 'eo')->exists()) {
            User::create([
                'name' => 'Organizer',
                'email' => 'organizer@konserkuy.com',
                'password' => Hash::make('password123'),
                'role' => 'eo',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't delete users in down method
    }
};
