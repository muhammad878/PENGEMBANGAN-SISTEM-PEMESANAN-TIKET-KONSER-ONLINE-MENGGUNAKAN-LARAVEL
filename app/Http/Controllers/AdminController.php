<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Tampilkan dashboard admin
     */
    public function dashboard()
    {
        // Statistik untuk dashboard
        $eventCount = Event::where('status', 'active')->count();
        $userCount = User::count();
        $ticketsSold = DB::table('transactions')->where('status', 'completed')->sum('ticket_count');

        // Event yang menunggu validasi
        $pendingEvents = Event::where('status', 'pending')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard.index', compact('eventCount', 'userCount', 'ticketsSold', 'pendingEvents'));
    }

    /**
     * Tampilkan daftar user
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Tampilkan detail user
     */
    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Update role user
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,eo,user',
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Role pengguna berhasil diperbarui');
    }

    /**
     * Toggle status user (active/inactive)
     */
    public function toggleUserStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Status pengguna berhasil diperbarui');
    }

    /**
     * Hapus user
     */
    public function destroyUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus');
    }

    /**
     * Tampilkan daftar event yang membutuhkan validasi
     */
    public function eventsValidation(Request $request)
    {
        $query = Event::where('status', 'pending');

        // Filter berdasarkan penyelenggara
        if ($request->filled('organizer')) {
            $query->where('organizer_id', $request->organizer);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('event_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('event_date', '<=', $request->end_date);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(10);
        $organizers = User::where('role', 'eo')->get();

        return view('admin.events.validation', compact('events', 'organizers'));
    }

    /**
     * Tampilkan detail event
     */
    public function showEvent(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Setujui event
     */
    public function approveEvent(Event $event)
    {
        $event->status = 'active';
        $event->save();

        // Kirim notifikasi ke penyelenggara (bisa diimplementasikan nanti)

        return redirect()->route('admin.events.validation')->with('success', 'Event berhasil disetujui');
    }

    /**
     * Tolak event
     */
    public function rejectEvent(Request $request, Event $event)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $event->status = 'rejected';
        $event->rejection_reason = $request->rejection_reason;
        $event->save();

        // Kirim notifikasi ke penyelenggara (bisa diimplementasikan nanti)

        return redirect()->route('admin.events.validation')->with('success', 'Event berhasil ditolak');
    }

    /**
     * Tampilkan laporan transaksi
     */
    public function transactionReports(Request $request)
    {
        $query = Transaction::query();

        // Filter berdasarkan event
        if ($request->filled('event')) {
            $query->where('event_id', $request->event);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('buyer_name', 'like', "%{$search}%")
                  ->orWhere('buyer_email', 'like', "%{$search}%");
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);
        $events = Event::where('status', 'active')->get();

        // Statistik transaksi
        $totalTransactions = Transaction::where('status', 'completed')->count();
        $totalRevenue = Transaction::where('status', 'completed')->sum('total_amount');
        $totalCommission = Transaction::where('status', 'completed')->sum('commission_amount');

        return view('admin.reports.transactions', compact(
            'transactions', 
            'events', 
            'totalTransactions', 
            'totalRevenue', 
            'totalCommission'
        ));
    }

    /**
     * Export laporan transaksi
     */
    public function exportReports()
    {
        // Implementasi export (bisa diimplementasikan nanti)
        return redirect()->route('admin.reports.transactions')->with('info', 'Fitur export akan segera tersedia');
    }
} 