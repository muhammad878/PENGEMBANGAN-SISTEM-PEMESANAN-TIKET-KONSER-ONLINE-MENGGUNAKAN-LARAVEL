<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function transactions(Request $request)
    {
        $query = Order::with(['user', 'event.user'])
            ->select([
                'orders.*',
                DB::raw('(SELECT COUNT(*) FROM order_items WHERE order_items.order_id = orders.id) as ticket_count'),
                DB::raw('(SELECT SUM(subtotal) FROM order_items WHERE order_items.order_id = orders.id) as total_amount'),
                DB::raw('(SELECT SUM(subtotal * 0.1) FROM order_items WHERE order_items.order_id = orders.id) as commission_amount')
            ]);

        // Filter berdasarkan pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan event
        if ($request->has('event') && $request->event != '') {
            $query->where('event_id', $request->event);
        }

        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Hitung total
        $totalTransactions = $query->count();
        $totalRevenue = $query->sum(DB::raw('(SELECT SUM(subtotal) FROM order_items WHERE order_items.order_id = orders.id)'));
        $totalCommission = $query->sum(DB::raw('(SELECT SUM(subtotal * 0.1) FROM order_items WHERE order_items.order_id = orders.id)'));

        // Ambil data untuk dropdown event
        $events = Event::select('id', 'title as name')->get();

        // Ambil data transaksi dengan pagination
        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.reports.transactions', compact(
            'transactions',
            'events',
            'totalTransactions',
            'totalRevenue',
            'totalCommission'
        ));
    }

    public function export()
    {
        // TODO: Implementasi export ke Excel
        return back()->with('error', 'Fitur export belum tersedia');
    }
} 