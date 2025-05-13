<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Support\Str;

class OrganizerController extends Controller
{
    /**
     * Display the organizer dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistik untuk dashboard
        $eventsCount = Event::where('user_id', $user->id)->count();
        $activeEventsCount = Event::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();
        
        $totalSales = DB::table('transactions')
            ->join('events', 'transactions.event_id', '=', 'events.id')
            ->where('events.user_id', $user->id)
            ->where('transactions.status', 'completed')
            ->sum('transactions.total_amount');
            
        $totalTicketsSold = DB::table('transactions')
            ->join('events', 'transactions.event_id', '=', 'events.id')
            ->where('events.user_id', $user->id)
            ->where('transactions.status', 'completed')
            ->sum('transactions.ticket_count');
            
        // Event terbaru
        $recentEvents = Event::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Pesanan terbaru
        $recentTransactions = Transaction::join('events', 'transactions.event_id', '=', 'events.id')
            ->where('events.user_id', $user->id)
            ->orderBy('transactions.created_at', 'desc')
            ->select('transactions.*', 'events.title as event_name')
            ->take(5)
            ->get();
            
        return view('organizer.dashboard', compact(
            'eventsCount', 
            'activeEventsCount', 
            'totalSales', 
            'totalTicketsSold',
            'recentEvents',
            'recentTransactions'
        ));
    }
    
    /**
     * Display list of organizer's events
     */
    public function events()
    {
        $user = Auth::user();
        $events = Event::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('organizer.events.index', compact('events'));
    }
    
    /**
     * Show form to create a new event
     */
    public function createEvent()
    {
        return view('organizer.events.create');
    }
    
    /**
     * Store a new event
     */
    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'maps_link' => 'nullable|string',
            'event_date' => 'required|date',
            'ticket_price' => 'required|numeric|min:0',
            'ticket_quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'venue_image' => 'nullable|image|max:2048',
            'category' => 'required|string',
        ]);
        
        // Find category or create it if it doesn't exist
        $categorySlug = Str::slug($validated['category']);
        $category = Category::firstOrCreate(
            ['slug' => $categorySlug],
            [
                'name' => $validated['category'],
                'slug' => $categorySlug,
                'description' => 'Kategori konser ' . $validated['category'],
            ]
        );
        
        $event = new Event();
        $event->title = $validated['name'];
        
        // Buat slug dari nama event dan tambahkan timestamp untuk memastikan keunikan
        $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $validated['name'])));
        $timestamp = time();
        $newSlug = $baseSlug . '-' . $timestamp;
        
        // Double check apakah slug sudah ada, jika ada tambahkan angka random
        while (Event::where('slug', $newSlug)->exists()) {
            $newSlug = $baseSlug . '-' . $timestamp . '-' . rand(1, 100);
        }
        
        $event->slug = $newSlug;
        $event->description = $validated['description'];
        $event->location = $validated['location'];
        $event->maps_link = $validated['maps_link'];
        $event->date = $validated['event_date'];
        $event->category = $validated['category'];
        $event->category_id = $category->id;
        $event->ticket_price = $validated['ticket_price'];
        $event->ticket_quantity = $validated['ticket_quantity'];
        $event->user_id = Auth::id();
        $event->status = 'pending'; // Status default: pending
        
        // Upload gambar jika ada
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $file = $request->file('image');
                
                // Debug info
                Log::info('Image upload details: ', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'error' => $file->getError()
                ]);
                
                // Alternatif penyimpanan untuk Windows
                // Simpan file langsung ke public/uploads/event-images
                $destinationPath = 'uploads/event-images';
                $publicPath = public_path($destinationPath);
                
                // Buat direktori jika belum ada
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0777, true);
                }
                
                // Generate nama file unik
                $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Pindahkan file langsung ke direktori public
                $file->move($publicPath, $fileName);
                
                // Simpan path relative
                $relativePath = $destinationPath . '/' . $fileName;
                $event->poster_path = $relativePath;
                
                // Log info untuk debugging
                Log::info('Saved poster_path: ' . $event->poster_path);
                
            } catch (\Exception $e) {
                Log::error('Error uploading image: ' . $e->getMessage());
                return back()->with('error', 'Gagal mengunggah gambar poster: ' . $e->getMessage())->withInput();
            }
        }
        
        // Upload gambar venue jika ada
        if ($request->hasFile('venue_image') && $request->file('venue_image')->isValid()) {
            try {
                $file = $request->file('venue_image');
                
                // Debug info
                Log::info('Venue image upload details: ', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'error' => $file->getError()
                ]);
                
                // Simpan file langsung ke public/uploads/venue-images
                $destinationPath = 'uploads/venue-images';
                $publicPath = public_path($destinationPath);
                
                // Buat direktori jika belum ada
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0777, true);
                }
                
                // Generate nama file unik
                $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Pindahkan file langsung ke direktori public
                $file->move($publicPath, $fileName);
                
                // Simpan path relative
                $relativePath = $destinationPath . '/' . $fileName;
                $event->venue_image_path = $relativePath;
                
                // Log info untuk debugging
                Log::info('Saved venue_image_path: ' . $event->venue_image_path);
                
            } catch (\Exception $e) {
                Log::error('Error uploading venue image: ' . $e->getMessage());
                return back()->with('error', 'Gagal mengunggah gambar venue: ' . $e->getMessage())->withInput();
            }
        }
        
        try {
            $event->save();
            
            // Log data event setelah disimpan
            Log::info('Event saved with data: ', [
                'id' => $event->id,
                'title' => $event->title,
                'poster_path' => $event->poster_path
            ]);
            
            return redirect()->route('organizer.events.index')
                ->with('success', 'Event berhasil dibuat dan sedang menunggu persetujuan admin.');
        } catch (\Exception $e) {
            Log::error('Error saving event: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan event: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Show an event details
     */
    public function showEvent($id)
    {
        $event = Event::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('organizer.events.show', compact('event'));
    }
    
    /**
     * Show form to edit an event
     */
    public function editEvent($id)
    {
        $event = Event::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('organizer.events.edit', compact('event'));
    }
    
    /**
     * Update an event
     */
    public function updateEvent(Request $request, $id)
    {
        $event = Event::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'maps_link' => 'nullable|string',
            'event_date' => 'required|date',
            'ticket_price' => 'required|numeric|min:0',
            'ticket_quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'venue_image' => 'nullable|image|max:2048',
            'category' => 'required|string',
        ]);
        
        // Find category or create it if it doesn't exist
        $categorySlug = Str::slug($validated['category']);
        $category = Category::firstOrCreate(
            ['slug' => $categorySlug],
            [
                'name' => $validated['category'],
                'slug' => $categorySlug,
                'description' => 'Kategori konser ' . $validated['category'],
            ]
        );
        
        $event->title = $validated['name'];
        
        // Buat slug dari nama event
        $newSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $validated['name'])));
        
        // Jika nama berubah, buat slug baru dengan timestamp untuk memastikan keunikan
        if ($event->title != $event->getOriginal('title')) {
            // Tambahkan timestamp untuk memastikan slug selalu unik
            $timestamp = time();
            $newSlug = $newSlug . '-' . $timestamp;
            
            // Double check apakah slug sudah ada, jika ada tambahkan angka random
            while (Event::where('slug', $newSlug)->where('id', '!=', $event->id)->exists()) {
                $newSlug = $newSlug . '-' . rand(1, 100);
            }
            
            $event->slug = $newSlug;
        }
        // Jika nama tidak berubah, pertahankan slug yang ada
        
        $event->description = $validated['description'];
        $event->location = $validated['location'];
        $event->maps_link = $validated['maps_link'];
        $event->date = $validated['event_date'];
        $event->category = $validated['category'];
        $event->category_id = $category->id;
        $event->ticket_price = $validated['ticket_price'];
        $event->ticket_quantity = $validated['ticket_quantity'];
        
        // Handle status change based on significant changes
        $significantChanges = false;
        
        // Check if important fields were changed that might require re-approval
        if ($event->isDirty('title') || $event->isDirty('description') || 
            $event->isDirty('date') || $event->isDirty('ticket_price')) {
            $significantChanges = true;
        }
        
        // Log poster path sebelum pembaruan
        Log::info('Existing poster_path before update: ' . $event->poster_path);
        
        // Upload gambar baru jika ada
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $file = $request->file('image');
                
                // Debug info
                Log::info('Update image upload details: ', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'error' => $file->getError()
                ]);
                
                // Delete old image if exists
                if ($event->poster_path) {
                    // Coba hapus file lama jika ada
                    $oldFilePath = public_path($event->poster_path);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                        Log::info('Deleted old image: ' . $oldFilePath);
                    }
                }
                
                // Alternatif penyimpanan untuk Windows
                // Simpan file langsung ke public/uploads/event-images
                $destinationPath = 'uploads/event-images';
                $publicPath = public_path($destinationPath);
                
                // Buat direktori jika belum ada
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0777, true);
                }
                
                // Generate nama file unik
                $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Pindahkan file langsung ke direktori public
                $file->move($publicPath, $fileName);
                
                // Simpan path relative
                $relativePath = $destinationPath . '/' . $fileName;
                Log::info('Image updated and stored at: ' . $relativePath);
                $event->poster_path = $relativePath;
                
                // Tambahan log untuk debugging
                Log::info('Updated poster_path in database: ' . $event->poster_path);
                
                $significantChanges = true;
            } catch (\Exception $e) {
                Log::error('Error uploading updated image: ' . $e->getMessage());
                return back()->with('error', 'Gagal mengunggah gambar: ' . $e->getMessage())->withInput();
            }
        }
        
        // Upload gambar venue baru jika ada
        if ($request->hasFile('venue_image') && $request->file('venue_image')->isValid()) {
            try {
                $file = $request->file('venue_image');
                
                // Debug info
                Log::info('Update venue image upload details: ', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'error' => $file->getError()
                ]);
                
                // Delete old venue image if exists
                if ($event->venue_image_path) {
                    // Coba hapus file lama jika ada
                    $oldFilePath = public_path($event->venue_image_path);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                        Log::info('Deleted old venue image: ' . $oldFilePath);
                    }
                }
                
                // Simpan file langsung ke public/uploads/venue-images
                $destinationPath = 'uploads/venue-images';
                $publicPath = public_path($destinationPath);
                
                // Buat direktori jika belum ada
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0777, true);
                }
                
                // Generate nama file unik
                $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Pindahkan file langsung ke direktori public
                $file->move($publicPath, $fileName);
                
                // Simpan path relative
                $relativePath = $destinationPath . '/' . $fileName;
                Log::info('Venue image updated and stored at: ' . $relativePath);
                $event->venue_image_path = $relativePath;
                
                // Tambahan log untuk debugging
                Log::info('Updated venue_image_path in database: ' . $event->venue_image_path);
                
                $significantChanges = true;
            } catch (\Exception $e) {
                Log::error('Error uploading updated venue image: ' . $e->getMessage());
                return back()->with('error', 'Gagal mengunggah gambar venue: ' . $e->getMessage())->withInput();
            }
        }
        
        // If there are significant changes and the event was already approved,
        // set it back to pending for admin review
        if ($significantChanges && $event->status === 'active') {
            $event->status = 'pending';
            $event->save();
            
            // Log data event setelah disimpan
            Log::info('Event updated with data: ', [
                'id' => $event->id,
                'title' => $event->title,
                'poster_path' => $event->poster_path
            ]);
            
            return redirect()->route('organizer.events.index')
                ->with('info', 'Event berhasil diperbarui dan sedang menunggu persetujuan ulang dari admin karena perubahan signifikan.');
        }
        
        $event->save();
        
        // Log data event setelah disimpan
        Log::info('Event updated with data: ', [
            'id' => $event->id,
            'title' => $event->title,
            'poster_path' => $event->poster_path
        ]);
        
        return redirect()->route('organizer.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }
    
    /**
     * Delete an event
     */
    public function destroyEvent($id)
    {
        $event = Event::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $event->delete();
        
        return redirect()->route('organizer.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
    
    /**
     * Display ticket management page
     */
    public function tickets($eventId)
    {
        $event = Event::where('id', $eventId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Get tickets for this event
        $tickets = Ticket::where('event_id', $eventId)->get();
            
        return view('organizer.tickets.index', compact('event', 'tickets'));
    }
    
    /**
     * Store a new ticket for an event
     */
    public function storeTicket(Request $request, $eventId)
    {
        $event = Event::where('id', $eventId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|string|max:50',
        ]);
        
        $ticket = new Ticket();
        $ticket->event_id = $event->id;
        $ticket->ticket_type = $validated['name'];
        $ticket->price = $validated['price'];
        $ticket->quota = $validated['quantity'];
        $ticket->sold = 0;
        $ticket->ticket_code = Str::random(10);
        $ticket->save();
        
        return redirect()->route('organizer.tickets.index', $event->id)
            ->with('success', 'Kategori tiket berhasil ditambahkan.');
    }
    
    /**
     * Show the form for editing a ticket
     */
    public function editTicket($eventId, $ticketId)
    {
        $event = Event::where('id', $eventId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $ticket = Ticket::where('id', $ticketId)
            ->where('event_id', $eventId)
            ->firstOrFail();
            
        return view('organizer.tickets.edit', compact('event', 'ticket'));
    }
    
    /**
     * Update a ticket
     */
    public function updateTicket(Request $request, $eventId, $ticketId)
    {
        $event = Event::where('id', $eventId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $ticket = Ticket::where('id', $ticketId)
            ->where('event_id', $eventId)
            ->firstOrFail();
            
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:' . ($ticket->quota - ($ticket->quota - $ticket->sold)),
            'type' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);
        
        // Calculate new remaining tickets
        $soldTickets = $ticket->sold;
        $newQuota = $validated['quantity'];
        
        $ticket->ticket_type = $validated['name'];
        $ticket->price = $validated['price'];
        $ticket->quota = $newQuota;
        $ticket->save();
        
        return redirect()->route('organizer.tickets.index', $event->id)
            ->with('success', 'Kategori tiket berhasil diperbarui.');
    }
    
    /**
     * Delete a ticket
     */
    public function destroyTicket($eventId, $ticketId)
    {
        $event = Event::where('id', $eventId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $ticket = Ticket::where('id', $ticketId)
            ->where('event_id', $eventId)
            ->firstOrFail();
            
        // Check if ticket has been sold
        if ($ticket->sold > 0) {
            return redirect()->route('organizer.tickets.index', $event->id)
                ->with('error', 'Tidak dapat menghapus kategori tiket yang sudah terjual.');
        }
        
        $ticket->delete();
        
        return redirect()->route('organizer.tickets.index', $event->id)
            ->with('success', 'Kategori tiket berhasil dihapus.');
    }
    
    /**
     * Display orders/transactions for organizer's events
     */
    public function orders()
    {
        $user = Auth::user();
        $events = Event::where('user_id', $user->id)->pluck('id');
        $orders = Order::whereIn('event_id', $events)
                    ->with(['user', 'items.ticket'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('organizer.orders.index', compact('orders'));
    }
    
    /**
     * Display order details
     *
     * @param int $id Order ID
     * @return \Illuminate\Http\Response
     */
    public function orderDetail($id)
    {
        $user = Auth::user();
        $order = Order::with(['items.ticket', 'user', 'event'])
                    ->findOrFail($id);
        
        // Check if order belongs to one of the organizer's events
        if ($order->event->user_id !== $user->id) {
            return redirect()->route('orders')->with('error', 'You are not authorized to view this order.');
        }
        
        return view('organizer.orders.show', [
            'order' => $order
        ]);
    }
    
    /**
     * Export orders as CSV
     */
    public function exportOrders()
    {
        $user = Auth::user();
        $events = Event::where('user_id', $user->id)->pluck('id');
        $orders = Order::whereIn('event_id', $events->toArray())
                    ->with(['user', 'items.ticket', 'items.event'])
                    ->get();
        
        // Nama file CSV
        $filename = 'orders_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        // Header untuk download file
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        // Buat callback untuk generate CSV
        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'Order ID',
                'Order Number',
                'Event',
                'Buyer Name',
                'Buyer Email',
                'Total Amount',
                'Payment Status',
                'Payment Method',
                'Order Date',
                'Ticket Type',
                'Ticket Quantity'
            ]);
            
            // Data orders
            foreach ($orders as $order) {
                foreach ($order->items as $item) {
                    fputcsv($file, [
                        $order->id,
                        $order->order_number,
                        $item->event->name ?? 'N/A',
                        $order->user->name ?? 'N/A',
                        $order->user->email ?? 'N/A',
                        $order->total_amount,
                        $order->payment_status,
                        $order->payment_method ?? 'N/A',
                        $order->created_at->format('Y-m-d H:i:s'),
                        $item->ticket->name ?? 'N/A',
                        $item->quantity
                    ]);
                }
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
} 