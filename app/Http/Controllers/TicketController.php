<?php

namespace App\Http\Controllers;

use App\Models\ETicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Auth middleware moved to route level
    }

    /**
     * Display a listing of the tickets.
     */
    public function index(Request $request)
    {
        // Redirect to payment history as requested by user
        return redirect()->route('payment.history');
    }
    
    /**
     * Redirect to payment history page as the main ticket dashboard.
     */
    public function dashboard()
    {
        return redirect()->route('payment.history');
    }
    
    /**
     * Display ticket history (same as index for backward compatibility).
     */
    public function history(Request $request)
    {
        return redirect()->route('payment.history');
    }

    /**
     * Display the specified ticket.
     */
    public function show(ETicket $ticket)
    {
        $this->authorizeForUser(auth()->user(), 'view', $ticket);

        // Load all relations, checking what's available
        if (Schema::hasColumn('e_tickets', 'order_id')) {
            $ticket->load(['order', 'order.event', 'user']);
        } else {
            $ticket->load(['orderItem', 'orderItem.order', 'orderItem.event', 'user']);
            
            // Set convenience properties for the view
            if ($ticket->orderItem && $ticket->orderItem->order) {
                $ticket->order = $ticket->orderItem->order;
            }
        }

        return view('user.tickets.show', compact('ticket'));
    }
    
    /**
     * Download the specified ticket as PDF.
     */
    public function download(ETicket $ticket)
    {
        $this->authorizeForUser(auth()->user(), 'download', $ticket);

        // Load all relations, checking what's available
        if (Schema::hasColumn('e_tickets', 'order_id')) {
            $ticket->load(['order', 'order.event', 'user']);
        } else {
            $ticket->load(['orderItem', 'orderItem.order', 'orderItem.event', 'user']);
            
            // Set convenience properties for the view
            if ($ticket->orderItem && $ticket->orderItem->order) {
                $ticket->order = $ticket->orderItem->order;
            }
        }

        // Check if DomPDF is available
        if (class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            $pdf = app('\Barryvdh\DomPDF\Facade\Pdf');
            $pdf = $pdf::loadView('user.tickets.pdf', compact('ticket'));
            
            $event_title = $ticket->order && $ticket->order->event ? $ticket->order->event->title : 'Event';
            return $pdf->download($event_title . ' - ' . $ticket->code . '.pdf');
        } else {
            // Fallback to HTML view if DomPDF is not available
            $html = View::make('user.tickets.pdf', compact('ticket'))->render();
            
            $event_title = $ticket->order && $ticket->order->event ? $ticket->order->event->title : 'Event';
            $filename = $event_title . ' - ' . $ticket->code . '.html';
            
            return Response::make($html, 200, [
                'Content-Type' => 'text/html',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
        }
    }
} 