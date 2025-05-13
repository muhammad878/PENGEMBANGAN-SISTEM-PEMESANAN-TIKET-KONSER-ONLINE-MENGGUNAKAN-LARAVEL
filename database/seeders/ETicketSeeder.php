<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\ETicket;
use Carbon\Carbon;

class ETicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah ada user
        $user = User::where('email', 'user@example.com')->first();
        
        if (!$user) {
            $this->command->info('User not found. Creating user...');
            $user = User::create([
                'name' => 'Test User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
            ]);
        }
        
        // Cek apakah ada order
        $order = Order::first();
        
        if (!$order) {
            $this->command->info('Order not found. Creating order...');
            $order = Order::create([
                'user_id' => $user->id,
                'event_id' => 1,  // Pastikan event_id 1 ada
                'order_number' => 'KUY' . now()->format('YmdHis') . rand(1000, 9999),
                'status' => 'paid',
                'payment_status' => 'paid',
                'payment_method' => 'bank_transfer',
                'total_amount' => 1500000,
            ]);
        }
        
        // Buat 5 e-ticket untuk order
        for ($i = 1; $i <= 5; $i++) {
            ETicket::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'code' => 'TICKET-' . $i . '-' . now()->timestamp,
                'status' => 'active',
                'is_used' => false,
                'event_date' => Carbon::now()->addDays(30),
            ]);
        }
        
        $this->command->info('5 e-tickets created successfully.');
    }
}
