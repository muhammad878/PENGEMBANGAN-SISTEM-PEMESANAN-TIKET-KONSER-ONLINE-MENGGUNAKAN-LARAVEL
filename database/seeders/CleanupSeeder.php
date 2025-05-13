<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleanupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean up transaction-related tables first (foreign key constraints)
        $this->command->info('Cleaning up transactions tables...');
        DB::table('transactions')->truncate();
        DB::table('order_items')->truncate();
        
        // Clean up tickets and events
        $this->command->info('Cleaning up tickets and events...');
        DB::table('tickets')->truncate();
        DB::table('events')->truncate();
        
        $this->command->info('All existing events and tickets data has been cleared.');
    }
} 