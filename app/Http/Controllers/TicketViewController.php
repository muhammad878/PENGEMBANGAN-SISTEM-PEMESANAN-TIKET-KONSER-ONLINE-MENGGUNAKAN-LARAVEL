<?php

namespace App\Http\Controllers;

use App\Models\ETicket;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketViewController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Check and update ticket status 
     * For example, mark as expired if the event date has passed
     *
     * @param Collection $tickets
     * @return Collection
     */
    private function checkAndUpdateTicketStatus($tickets)
    {
        $now = now();
        
        foreach ($tickets as $key => $ticket) {
            // Get the event date either from ticket or from order->event
            $eventDate = null;
            
            if (isset($ticket->event_date)) {
                $eventDate = $ticket->event_date;
            } elseif (isset($ticket->order) && isset($ticket->order->event) && isset($ticket->order->event->date)) {
                $eventDate = $ticket->order->event->date;
            }
            
            // Skip if no event date found
            if (!$eventDate) {
                continue;
            }
            
            // Check if expired (event date passed and ticket not used)
            if ($eventDate < $now && 
                $ticket->status !== 'used' && 
                (!isset($ticket->is_used) || !$ticket->is_used)) {
                
                // For database records, update status
                if (isset($ticket->id) && !is_null($ticket->id) && is_numeric($ticket->id)) {
                    try {
                        $realTicket = ETicket::find($ticket->id);
                        if ($realTicket) {
                            $realTicket->status = 'expired';
                            $realTicket->save();
                            
                            // Update the collection item as well
                            $ticket->status = 'expired';
                        }
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Error updating ticket status: ' . $e->getMessage());
                    }
                } else {
                    // For mock data, just update the status in the collection
                    $ticket->status = 'expired';
                }
            }
        }
        
        return $tickets;
    }

    /**
     * Display a listing of the user's tickets.
     */
    public function index()
    {
        try {
            // Get user's tickets directly
            $tickets = ETicket::where('user_id', Auth::id())
                ->with(['order.event'])
                ->latest()
                ->get();

            // Get mock tickets for testing if no tickets exist
            if ($tickets->isEmpty()) {
                $tickets = $this->getMockTickets();
                Log::info('Using mock tickets for user ' . Auth::id() . ' as no actual tickets were found');
            }
            
            // Check and update ticket status
            $tickets = $this->checkAndUpdateTicketStatus($tickets);

            return view('frontend.tickets.index', [
                'tickets' => $tickets,
                'totalTickets' => $tickets->count(),
                'activeTickets' => $tickets->where('status', 'active')->count(),
                'usedTickets' => $tickets->where('status', 'used')->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Error displaying tickets: ' . $e->getMessage());
            return view('frontend.tickets.index', [
                'error' => 'Error retrieving tickets: ' . $e->getMessage(),
                'tickets' => collect(),
                'totalTickets' => 0,
                'activeTickets' => 0,
                'usedTickets' => 0
            ]);
        }
    }

    /**
     * Display the specified ticket.
     */
    public function show($id)
    {
        try {
            // Find the ticket for the current user
            $ticket = ETicket::where('user_id', Auth::id())
                ->where('id', $id)
                ->with(['order.event'])
                ->first();

            // If ticket not found
            if (!$ticket) {
                // Try to find if the ticket exists but doesn't belong to the user
                $ticketExists = ETicket::where('id', $id)->exists();
                
                if ($ticketExists) {
                    Log::warning('User ' . Auth::id() . ' attempted to access ticket #' . $id . ' that belongs to another user');
                    return view('frontend.tickets.show', [
                        'error' => 'Anda tidak memiliki akses untuk melihat tiket ini.',
                        'ticket' => null
                    ]);
                }
                
                // If in development, use mock data
                if (app()->environment('local', 'development')) {
                    Log::info('Using mock ticket for ID ' . $id . ' in ' . app()->environment() . ' environment');
                    $ticket = $this->getMockTickets()->first();
                    
                    // Check and update mock ticket status
                    $tickets = collect([$ticket]);
                    $tickets = $this->checkAndUpdateTicketStatus($tickets);
                    $ticket = $tickets->first();
                    
                    return view('frontend.tickets.show', ['ticket' => $ticket]);
                }

                // In production, show error
                Log::warning('Ticket #' . $id . ' not found for user ' . Auth::id());
                return view('frontend.tickets.show', [
                    'error' => 'Tiket tidak ditemukan.',
                    'ticket' => null
                ]);
            }
            
            // Check and update ticket status
            $tickets = collect([$ticket]);
            $tickets = $this->checkAndUpdateTicketStatus($tickets);
            $ticket = $tickets->first();

            return view('frontend.tickets.show', ['ticket' => $ticket]);
        } catch (\Exception $e) {
            Log::error('Error showing ticket #' . $id . ': ' . $e->getMessage());
            return view('frontend.tickets.show', [
                'error' => 'Error retrieving ticket: ' . $e->getMessage(),
                'ticket' => null
            ]);
        }
    }

    /**
     * Generate mock tickets for testing purposes
     */
    private function getMockTickets($count = 3)
    {
        $mockTickets = collect();
        
        $eventTitles = [
            'Coldplay Live in Jakarta',
            'NCT Dream Fanmeeting',
            'Java Jazz Festival',
            'Blackpink World Tour',
            'Ed Sheeran Concert'
        ];
        
        $venues = [
            'Jakarta International Stadium',
            'Indonesia Convention Exhibition (ICE)',
            'Gelora Bung Karno Stadium',
            'Jakarta Convention Center',
            'Sentul International Convention Center'
        ];
        
        // Generate multiple mock tickets
        for ($i = 0; $i < $count; $i++) {
            $eventIndex = array_rand($eventTitles);
            $venueIndex = array_rand($venues);
            $eventDate = now()->addDays(rand(5, 60));
            $isUsed = rand(0, 3) === 0; // 1 in 4 chance of being used
            
            $mockTickets->push((object)[
                'id' => $i + 1,
                'code' => 'TIX-' . rand(10000, 99999),
                'status' => $isUsed ? 'used' : 'active',
                'is_used' => $isUsed,
                'user_id' => Auth::id(),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
                'event_date' => $eventDate,
                'used_at' => $isUsed ? $eventDate : null,
                'order' => (object)[
                    'id' => $i + 1,
                    'order_number' => 'ORD-' . rand(100000, 999999),
                    'total_amount' => rand(100000, 1000000),
                    'payment_status' => 'paid',
                    'event' => (object)[
                        'id' => $i + 1,
                        'title' => $eventTitles[$eventIndex],
                        'location' => $venues[$venueIndex],
                        'date' => $eventDate,
                        'image' => 'storage/images/events/' . strtolower(str_replace(' ', '', explode(' ', $eventTitles[$eventIndex])[0])) . '.jpg'
                    ]
                ]
            ]);
        }

        return $mockTickets;
    }
}
