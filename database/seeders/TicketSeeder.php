<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all events
        $events = Event::all();

        foreach ($events as $event) {
            // Different ticket types for each event
            
            // VIP/Platinum Tickets
            Ticket::create([
                'event_id' => $event->id,
                'ticket_type' => 'VIP',
                'price' => $event->ticket_price * 2.5, // VIP tickets at 2.5x base price
                'quota' => ceil($event->ticket_quantity * 0.1), // 10% of total tickets are VIP
                'sold' => 0,
                'ticket_code' => 'VIP-' . strtoupper(Str::random(8)) . '-' . $event->id,
                'sale_start_date' => now(),
                'sale_end_date' => $event->date->copy()->subDay(),
            ]);

            // Gold Tickets
            Ticket::create([
                'event_id' => $event->id,
                'ticket_type' => 'Gold',
                'price' => $event->ticket_price * 1.5, // Gold tickets at 1.5x base price
                'quota' => ceil($event->ticket_quantity * 0.2), // 20% of total tickets are Gold
                'sold' => 0,
                'ticket_code' => 'GOLD-' . strtoupper(Str::random(8)) . '-' . $event->id,
                'sale_start_date' => now(),
                'sale_end_date' => $event->date->copy()->subDay(),
            ]);

            // Silver Tickets
            Ticket::create([
                'event_id' => $event->id,
                'ticket_type' => 'Silver',
                'price' => $event->ticket_price * 1.2, // Silver tickets at 1.2x base price
                'quota' => ceil($event->ticket_quantity * 0.3), // 30% of total tickets are Silver
                'sold' => 0,
                'ticket_code' => 'SILVER-' . strtoupper(Str::random(8)) . '-' . $event->id,
                'sale_start_date' => now(),
                'sale_end_date' => $event->date->copy()->subDay(),
            ]);

            // Regular Tickets
            Ticket::create([
                'event_id' => $event->id,
                'ticket_type' => 'Regular',
                'price' => $event->ticket_price, // Regular tickets at base price
                'quota' => ceil($event->ticket_quantity * 0.4), // 40% of total tickets are Regular
                'sold' => 0,
                'ticket_code' => 'REG-' . strtoupper(Str::random(8)) . '-' . $event->id,
                'sale_start_date' => now(),
                'sale_end_date' => $event->date->copy()->subDay(),
            ]);

            // For some events, create special tickets like early bird or group packages
            if ($event->id % 3 == 0) { // Every third event
                Ticket::create([
                    'event_id' => $event->id,
                    'ticket_type' => 'Early Bird',
                    'price' => $event->ticket_price * 0.8, // 20% discount
                    'quota' => ceil($event->ticket_quantity * 0.05), // 5% of total tickets
                    'sold' => ceil($event->ticket_quantity * 0.03), // Most already sold
                    'ticket_code' => 'EARLY-' . strtoupper(Str::random(8)) . '-' . $event->id,
                    'sale_start_date' => now()->subDays(30),
                    'sale_end_date' => now()->addDays(7), // Limited time offer
                ]);
            }

            // For festivals, create multi-day passes
            if (str_contains(strtolower($event->title), 'festival')) {
                Ticket::create([
                    'event_id' => $event->id,
                    'ticket_type' => 'Festival Pass',
                    'price' => $event->ticket_price * 2.2, // Full festival pass price
                    'quota' => ceil($event->ticket_quantity * 0.15),
                    'sold' => ceil($event->ticket_quantity * 0.05),
                    'ticket_code' => 'FEST-' . strtoupper(Str::random(8)) . '-' . $event->id,
                    'sale_start_date' => now(),
                    'sale_end_date' => $event->date->copy()->subDay(),
                ]);

                Ticket::create([
                    'event_id' => $event->id,
                    'ticket_type' => 'Day Pass',
                    'price' => $event->ticket_price * 0.9, // Single day pass at 90% of regular price
                    'quota' => ceil($event->ticket_quantity * 0.25),
                    'sold' => ceil($event->ticket_quantity * 0.05),
                    'ticket_code' => 'DAY-' . strtoupper(Str::random(8)) . '-' . $event->id,
                    'sale_start_date' => now(),
                    'sale_end_date' => $event->date->copy()->subDay(),
                ]);
            }

            // For some events, add meet & greet packages
            if (in_array($event->category, ['Pop', 'K-Pop', 'Rock'])) {
                Ticket::create([
                    'event_id' => $event->id,
                    'ticket_type' => 'Meet & Greet',
                    'price' => $event->ticket_price * 4, // Premium package at 4x base price
                    'quota' => ceil($event->ticket_quantity * 0.02), // Very limited
                    'sold' => ceil($event->ticket_quantity * 0.01), // Half already sold
                    'ticket_code' => 'MEET-' . strtoupper(Str::random(8)) . '-' . $event->id,
                    'sale_start_date' => now(),
                    'sale_end_date' => $event->date->copy()->subDays(7), // Ends a week before event
                ]);
            }

            // For Classical events, add box seating
            if ($event->category === 'Classical') {
                Ticket::create([
                    'event_id' => $event->id,
                    'ticket_type' => 'Box Seating',
                    'price' => $event->ticket_price * 3, // Box seating at 3x base price
                    'quota' => 10, // Very limited boxes
                    'sold' => 5, // Some already reserved
                    'ticket_code' => 'BOX-' . strtoupper(Str::random(8)) . '-' . $event->id,
                    'sale_start_date' => now(),
                    'sale_end_date' => $event->date->copy()->subDay(),
                ]);
            }
        }
    }
} 