<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        try {
            // Get the authenticated user's orders with all necessary relationships
            $orders = Auth::user()->orders()
                ->with(['items.ticket', 'items.event', 'payment'])
                ->latest()
                ->paginate(10);
            
            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Error fetching user orders: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('dashboard')
                ->with('error', 'Terjadi kesalahan saat mengambil data pesanan. Silakan coba lagi nanti.');
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        try {
            // Check if the order belongs to the authenticated user
            if ($order->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }
            
            // Load necessary relationships
            $order->load(['items.ticket.event', 'payment', 'user']);
            
            return view('orders.show', compact('order'));
        } catch (\Exception $e) {
            Log::error('Error showing order details: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('orders.index')
                ->with('error', 'Terjadi kesalahan saat menampilkan detail pesanan. Silakan coba lagi nanti.');
        }
    }
    
    /**
     * Generate and download an invoice for the order
     */
    public function invoice(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            // Load necessary relationships
            $order->load(['items.ticket.event', 'payment', 'user']);
            
            // Generate PDF invoice (implementation would depend on your PDF library)
            // For example, using dompdf:
            // $pdf = \PDF::loadView('orders.invoice', compact('order'));
            // return $pdf->download('invoice-' . $order->order_number . '.pdf');
            
            // For now, just return a view
            return view('orders.invoice', compact('order'));
        } catch (\Exception $e) {
            Log::error('Error generating invoice: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('orders.show', $order)
                ->with('error', 'Terjadi kesalahan saat menghasilkan invoice. Silakan coba lagi nanti.');
        }
    }
} 