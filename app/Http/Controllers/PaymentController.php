<?php

namespace App\Http\Controllers;

use App\Models\ETicket;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display payment page for the order
     *
     * @param  int  $orderId
     * @return \Illuminate\Http\Response
     */
    public function show($orderId)
    {
        $order = Order::with(['items.ticket', 'items.ticket.event', 'user', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        // If order already paid, redirect to my tickets
        if ($order->payment_status === 'paid') {
            return redirect()->route('tickets.index')
                ->with('success', 'Pesanan ini telah dibayar. Berikut adalah tiket Anda.');
        }

        // Get payment instructions based on payment method
        $paymentInstructions = $this->getPaymentInstructions($order->payment_method);

        return view('frontend.payment.show', compact('order', 'paymentInstructions'));
    }

    /**
     * Upload payment proof and confirm payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $orderId
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request, $orderId)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $order = Order::with('items.ticket')
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        // If order already paid, redirect
        if ($order->payment_status === 'paid') {
            return redirect()->route('tickets.index')
                ->with('success', 'Pesanan ini telah dibayar sebelumnya.');
        }

        // Upload payment proof and create payment record with transaction
        DB::beginTransaction();
        try {
            // Upload payment proof
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $filename = 'payment_' . $order->order_number . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/payments', $filename);
                $publicPath = Storage::url($path);
                
                // Update order status
                $order->payment_status = 'processing';
                $order->save();
                
                // Create or update payment record
                $payment = Payment::firstOrNew(['order_id' => $order->id]);
                $payment->payment_method = $order->payment_method;
                $payment->payment_code = Payment::generatePaymentCode();
                $payment->status = 'pending'; // Will be updated to 'completed' when approved
                $payment->proof_of_payment = $publicPath;
                $payment->notes = 'Bukti pembayaran diunggah oleh pengguna pada ' . now()->format('d F Y H:i');
                $payment->save();
                
                // For demo purposes, we'll automatically confirm the payment
                // In a real app, this would be confirmed by admin after verifying the payment
                $this->autoConfirmPayment($order);
                
                DB::commit();
                
                return redirect()->route('payment.success', $order->id)
                    ->with('success', 'Bukti pembayaran berhasil diunggah. Pembayaran sedang diproses.');
            }
            
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengunggah bukti pembayaran. Silakan coba lagi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show payment success page
     *
     * @param  int  $orderId
     * @return \Illuminate\Http\Response
     */
    public function success($orderId)
    {
        $order = Order::with(['items.ticket', 'items.ticket.event', 'user', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        return view('frontend.payment.success', compact('order'));
    }

    /**
     * Display payment history for authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        try {
            // Log the method call for debugging
            \Illuminate\Support\Facades\Log::info('PaymentController@history called by user: ' . Auth::id());
            
            // Get orders with items and tickets
            $orders = Order::where('user_id', Auth::id())
                ->with(['items.ticket', 'items.ticket.event', 'items.event', 'eTickets', 'payment'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Get all e-tickets for the current user
            $allTickets = ETicket::where('user_id', Auth::id())
                ->get();

            // Calculate ticket statistics
            $ticketsCount = $allTickets->count();
            $activeTicketsCount = $allTickets->where('status', 'active')->where('is_used', 0)->count();
            $usedTicketsCount = $allTickets->where(function($query) {
                return $query->status == 'used' || $query->is_used == 1;
            })->count();
            $expiredTicketsCount = $allTickets->where('status', 'expired')->count();

            // Debug info
            \Illuminate\Support\Facades\Log::info('Payment history data loaded successfully', [
                'orders_count' => $orders->count(),
                'tickets_count' => $ticketsCount
            ]);

            // Return the view with the data
            return view('frontend.payment.history', compact(
                'orders',
                'allTickets',
                'ticketsCount', 
                'activeTicketsCount',
                'usedTicketsCount',
                'expiredTicketsCount'
            ));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in payment history: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            
            return view('frontend.payment.history', [
                'error' => 'Terjadi kesalahan saat menampilkan riwayat pembayaran: ' . $e->getMessage(),
                'orders' => collect(),
                'allTickets' => collect(),
                'ticketsCount' => 0,
                'activeTicketsCount' => 0,
                'usedTicketsCount' => 0,
                'expiredTicketsCount' => 0
            ]);
        }
    }

    /**
     * Display ticket details
     *
     * @param  int  $ticketId
     * @return \Illuminate\Http\Response
     */
    public function ticketDetails($ticketId)
    {
        $ticket = ETicket::where('user_id', Auth::id())->findOrFail($ticketId);
        
        if (Schema::hasColumn('e_tickets', 'order_id')) {
            $ticket->load(['order', 'order.event', 'order.items']);
        } else {
            $ticket->load(['orderItem', 'orderItem.order', 'orderItem.event']);
        }
        
        return view('frontend.payment.tickets-details', compact('ticket'));
    }

    /**
     * Debug ticket details - a simplified method
     *
     * @param  int  $ticketId
     * @return \Illuminate\Http\Response
     */
    public function debugTicket($ticketId)
    {
        try {
            $ticket = ETicket::findOrFail($ticketId);
            
            return view('frontend.payment.tickets-details', compact('ticket'));
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Get payment instructions based on method
     *
     * @param  string  $method
     * @return array
     */
    private function getPaymentInstructions($method)
    {
        $instructions = [
            'bank_transfer' => [
                'title' => 'Transfer Bank',
                'steps' => [
                    'Lakukan transfer ke rekening berikut:',
                    'Bank BCA: 8720145678 a.n. PT KonserKUY',
                    'Bank Mandiri: 1560003456789 a.n. PT KonserKUY',
                    'Bank BNI: 0459876543 a.n. PT KonserKUY',
                ],
                'note' => 'Pastikan Anda mencantumkan nomor pesanan pada keterangan transfer.'
            ],
            'e_wallet' => [
                'title' => 'E-Wallet',
                'steps' => [
                    'Pilih salah satu e-wallet berikut:',
                    'GoPay: 085712345678',
                    'OVO: 085712345678',
                    'DANA: 085712345678',
                    'LinkAja: 085712345678',
                ],
                'note' => 'Gunakan nomor pesanan sebagai keterangan pembayaran.'
            ],
            'credit_card' => [
                'title' => 'Kartu Kredit',
                'steps' => [
                    'Pembayaran dengan kartu kredit sedang dalam pengembangan.',
                    'Silakan gunakan metode pembayaran lain untuk saat ini.',
                ],
                'note' => 'Maaf atas ketidaknyamanan ini.'
            ],
        ];

        return $instructions[$method] ?? $instructions['bank_transfer'];
    }

    /**
     * Auto confirm payment (for demo purposes)
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    private function autoConfirmPayment($order)
    {
        // Update order status to paid
        $order->payment_status = 'paid';
        $order->status = 'completed';
        $order->save();
        
        // Update payment status
        $payment = Payment::where('order_id', $order->id)->first();
        if ($payment) {
            $payment->status = 'completed';
            $payment->paid_at = now();
            $payment->save();
        }
        
        // This would typically be done by an admin after verifying the payment
        // For demo purposes, we're automatically confirming it
    }
} 