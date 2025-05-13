<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use App\Models\Venue;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class FrontendController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Get featured events (active events)
        $featuredEvents = Event::where('status', 'active')
            ->orderBy('date', 'asc')
            ->take(8)
            ->get();
            
        // Get categories with event count
        $categories = Category::withCount('events')
            ->get()
            ->map(function($category) {
                return (object) [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'event_count' => $category->events_count
                ];
            });

        // Get featured venues (those with most events)
        $venues = DB::table('events')
            ->select('location', DB::raw('count(*) as event_count'))
            ->where('status', 'active')
            ->groupBy('location')
            ->orderBy('event_count', 'desc')
            ->take(6)
            ->get()
            ->map(function($item) {
                return (object) [
                    'name' => $item->location,
                    'slug' => Str::slug($item->location),
                    'event_count' => $item->event_count,
                    'capacity' => rand(5000, 50000),
                    'type' => collect(['Indoor', 'Outdoor', 'Mixed'])->random(),
                    'upcoming_events' => rand(1, 10)
                ];
            });

        return view('frontend.pages.home', compact('featuredEvents', 'categories', 'venues'));
    }
    
    /**
     * Display all events page
     */
    public function events(Request $request)
    {
        $query = Event::where('status', 'active');
        
        // Apply filters if any
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        
        if ($request->has('date')) {
            $date = $request->date;
            if ($date === 'today') {
                $query->whereDate('date', today());
            } elseif ($date === 'week') {
                $query->whereBetween('date', [today(), today()->addDays(7)]);
            } elseif ($date === 'month') {
                $query->whereBetween('date', [today(), today()->addDays(30)]);
            } elseif ($date === 'next-month') {
                $query->whereBetween('date', [today()->addDays(30), today()->addDays(60)]);
            }
        }
        
        // Get all events with pagination
        $events = $query->orderBy('date', 'asc')->paginate(12);
        
        // Debug: Log poster paths for front page events
        foreach ($events as $event) {
            Log::info('Events page - Event: ' . $event->title . ' - Poster path: ' . $event->poster_path);
        }
        
        // Get all categories for filter
        $categories = Category::all();
            
        // Get all locations for filter
        $locations = DB::table('events')
            ->select('location')
            ->where('status', 'active')
            ->groupBy('location')
            ->get();
            
        return view('frontend.pages.events', compact('events', 'categories', 'locations'));
    }
    
    /**
     * Display single event details
     */
    public function eventDetail($slug)
    {
        // Find the event by slug
        $event = Event::where('slug', $slug)->firstOrFail();
        
        // Debug: Log event detail poster path
        Log::info('Event detail page - Event: ' . $event->title . ' - Poster path: ' . $event->poster_path);
        
        // Get category details
        $category = Category::find($event->category_id);
        if ($category) {
            $event->category_name = $category->name;
            $event->category_slug = $category->slug;
        } else {
            $event->category_name = 'Uncategorized';
            $event->category_slug = 'uncategorized';
        }
        
        // Load tickets for this event from the database
        $tickets = Ticket::where('event_id', $event->id)->get();
        
        // If no tickets found, create a default ticket based on event info
        if ($tickets->isEmpty()) {
            $tickets = collect([
                (object) [
                    'id' => 0,
                    'ticket_type' => 'Regular',
                    'price' => $event->ticket_price,
                    'quota' => $event->ticket_quantity,
                    'sold' => 0,
                    'isAvailable' => true,
                ]
            ]);
        }
        
        $event->tickets = $tickets;

        // Get related events based on same category
        $relatedEvents = Event::where('status', 'active')
            ->where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->orderBy('date', 'asc')
            ->take(4)
            ->get();
        
        // Debug: Log related events poster paths
        foreach ($relatedEvents as $relatedEvent) {
            Log::info('Event detail page - Related event: ' . $relatedEvent->title . ' - Poster path: ' . $relatedEvent->poster_path);
        }

        return view('frontend.pages.event-detail', compact('event', 'relatedEvents'));
    }
    
    /**
     * Display categories page
     */
    public function categories()
    {
        // Get all categories with event count
        $categories = Category::withCount('events')
            ->get()
            ->map(function($category) {
                return (object) [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'event_count' => $category->events_count,
                    'icon' => $this->getCategoryIcon($category->name)
                ];
            });

        return view('frontend.pages.categories', compact('categories'));
    }
    
    /**
     * Display a specific category detail
     */
    public function showCategory($slug)
    {
        // Find category by slug
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Get events in this category
        $events = Event::where('category_id', $category->id)
            ->where('status', 'active')
            ->orderBy('date', 'asc')
            ->paginate(12);
            
        return view('frontend.pages.category-detail', compact('category', 'events'));
    }
    
    /**
     * Display events by category (alias for showCategory)
     */
    public function eventsByCategory($slug)
    {
        return $this->showCategory($slug);
    }
    
    /**
     * Display venues page
     */
    public function venues()
    {
        // Get all unique venue locations with event counts from actual data
        $venues = DB::table('events')
            ->select('location', DB::raw('count(*) as event_count'))
            ->where('status', 'active')
            ->groupBy('location')
            ->get()
            ->map(function($item) {
                return (object) [
                    'name' => $item->location,
                    'slug' => Str::slug($item->location),
                    'event_count' => $item->event_count,
                    // Add random venue type for display
                    'type' => collect(['Indoor', 'Outdoor', 'Mixed'])->random(),
                    'capacity' => rand(5000, 50000),
                    'upcoming_events' => rand(1, 5)
                ];
            });
            
        return view('frontend.pages.venues', compact('venues'));
    }
    
    /**
     * Display single venue with its events
     */
    public function showVenue($slug)
    {
        // Debug untuk melacak slug yang diakses
        \Illuminate\Support\Facades\Log::debug("Mencari venue dengan slug: $slug");

        // Kasus khusus untuk beberapa slug yang diketahui
        if ($slug === 'pantai-clumik-jepara') {
            $slug = 'pantai-clumik';
        }
        
        // Find venue by slug (converted from location)
        $location = str_replace('-', ' ', $slug);
        $location = ucwords($location);
        
        // Log untuk debugging
        \Illuminate\Support\Facades\Log::debug("Mencari venue dengan slug: $slug, dikonversi ke location: $location");
        
        // Coba berbagai pendekatan pencarian
        $locationWithoutCommas = str_replace(',', '', $location);
        
        // Check if venue exists dengan berbagai kemungkinan format
        $venueExists = Event::where('location', 'like', "%$location%")
            ->orWhere('location', 'like', "%$locationWithoutCommas%")
            ->exists();
        
        if (!$venueExists) {
            \Illuminate\Support\Facades\Log::debug("Venue tidak ditemukan untuk slug: $slug");
            abort(404);
        }
        
        // Get venue info - juga coba dengan format alternatif
        $venueInfo = DB::table('events')
            ->select('location', DB::raw('count(*) as event_count'))
            ->where(function($query) use ($location, $locationWithoutCommas) {
                $query->where('location', 'like', "%$location%")
                      ->orWhere('location', 'like', "%$locationWithoutCommas%");
            })
            ->groupBy('location')
            ->first();
            
        $venue = (object) [
            'name' => $venueInfo->location,
            'slug' => Str::slug($venueInfo->location),
            'event_count' => $venueInfo->event_count,
            'type' => collect(['Indoor', 'Outdoor', 'Mixed'])->random(),
            'capacity' => rand(5000, 50000),
            'upcoming_events' => rand(1, 5)
        ];
        
        // Get events at this venue
        $events = Event::where(function($query) use ($location, $locationWithoutCommas) {
                $query->where('location', 'like', "%$location%")
                      ->orWhere('location', 'like', "%$locationWithoutCommas%");
            })
            ->where('status', 'active')
            ->orderBy('date', 'asc')
            ->paginate(12);
            
        $venueName = $venueInfo->location;
        
        // Get maps_link and venue_image_path from the first event at this venue
        $venueDetails = Event::where(function($query) use ($location, $locationWithoutCommas) {
                $query->where('location', 'like', "%$location%")
                      ->orWhere('location', 'like', "%$locationWithoutCommas%");
            })
            ->where(function($query) {
                $query->whereNotNull('maps_link')
                      ->orWhereNotNull('venue_image_path');
            })
            ->first();
            
        $mapsLink = $venueDetails && $venueDetails->maps_link ? $venueDetails->maps_link : null;
        $venueImagePath = $venueDetails && $venueDetails->venue_image_path ? $venueDetails->venue_image_path : null;
            
        return view('frontend.pages.venue-detail', compact('venueName', 'venue', 'events', 'mapsLink', 'venueImagePath'));
    }
    
    /**
     * Display about page
     */
    public function about()
    {
        return view('frontend.pages.about');
    }
    
    /**
     * Display contact page
     */
    public function contact()
    {
        return view('frontend.pages.contact');
    }
    
    /**
     * Handle contact form submission.
     */
    public function contactSend(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Here you would typically send an email or store the contact submission
        // For example:
        // Mail::to('admin@konserkuy.com')->send(new ContactFormMail($validated));
        // or
        // ContactSubmission::create($validated);
        
        return redirect()->route('contact')->with('success', 'Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
    
    /**
     * Display FAQ page
     */
    public function faq()
    {
        return view('frontend.pages.faq');
    }
    
    /**
     * Display terms and conditions page
     */
    public function terms()
    {
        return view('frontend.pages.terms');
    }
    
    /**
     * Display privacy policy page
     */
    public function privacy()
    {
        return view('frontend.pages.privacy');
    }
    
    /**
     * Display help center page
     */
    public function help()
    {
        return view('frontend.pages.help');
    }
    
    /**
     * Return an icon name for a category based on its name
     */
    private function getCategoryIcon($name)
    {
        $categoryIcons = [
            'K-Pop' => 'lightning',
            'Pop' => 'plus', 
            'Rock' => 'refresh',
            'Jazz' => 'refresh',
            'Electronic' => 'plus',
            'Indie' => 'music',
            'Classical' => 'info',
            'Festival' => 'microphone'
        ];
        
        $defaultIcons = [
            'music', 'star', 'lightning', 'info', 'refresh', 
            'play', 'plus', 'microphone'
        ];
        
        // Use specific icon if defined for this category
        if (isset($categoryIcons[$name])) {
            return $categoryIcons[$name];
        }
        
        // Fall back to a consistent hash-based icon
        $hash = crc32($name);
        return $defaultIcons[$hash % count($defaultIcons)];
    }
    
    /**
     * Add to cart
     */
    public function addToCart(Request $request)
    {
        // In a real app, this would add to a session-based cart
        // For now, just redirect back with a success message
        return redirect()->back()->with('success', 'Tiket telah ditambahkan ke keranjang!');
    }
    
    /**
     * Show the checkout page
     */
    public function checkout()
    {
        // Get cart items from session
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('events')->with('error', 'Keranjang Anda kosong. Silakan pilih tiket terlebih dahulu.');
        }
        
        // Debug cart data
        Log::debug('Starting checkout process', [
            'cart_count' => count($cart),
            'cart_keys' => array_keys($cart),
            'session_id' => session()->getId()
        ]);
        
        try {
            $cartItems = [];
            $subtotal = 0;
            $eventIds = [];
            $events = []; // Array untuk menyimpan semua event
            
            // Process cart items and calculate totals
            foreach ($cart as $cartKey => $item) {
                // Validasi data item
                if (!isset($item['quantity']) || (int)$item['quantity'] <= 0) {
                    Log::warning('Skipping cart item with invalid quantity', ['key' => $cartKey]);
                    continue;
                }
                
                // Periksa apakah ini composite key (eventId_ticketId)
                $parts = explode('_', $cartKey);
                $eventId = isset($parts[0]) ? (int)$parts[0] : ($item['event_id'] ?? null);
                $ticketId = isset($parts[1]) ? (int)$parts[1] : null;
                
                // Skip jika tidak ada event ID
                if (!$eventId) {
                    Log::warning('Skipping cart item with missing event ID', ['key' => $cartKey]);
                    continue;
                }
                
                // Coba dapatkan data event dari database
                $event = null;
                if (!isset($events[$eventId])) {
                    $event = Event::find($eventId);
                    
                    // Jika event ditemukan
                    if ($event) {
                        $events[$eventId] = $event;
                        $eventIds[$eventId] = $eventId;
                    } 
                    // Jika event tidak ditemukan, buat objek sementara
                    else {
                        $event = new \stdClass();
                        $event->id = $eventId;
                        $event->title = $item['event_title'] ?? 'Event';
                        $event->date = isset($item['event_date']) ? (is_string($item['event_date']) ? \Carbon\Carbon::parse($item['event_date']) : $item['event_date']) : null;
                        $event->location = $item['event_location'] ?? '';
                        $event->poster_path = $item['event_poster'] ?? null;
                        
                        $events[$eventId] = $event;
                        $eventIds[$eventId] = $eventId;
                    }
                } else {
                    $event = $events[$eventId];
                }
                
                // Siapkan nilai-nilai untuk item
                $itemQuantity = (int)$item['quantity'];
                $itemPrice = (float)$item['price'];
                $itemSubtotal = $itemPrice * $itemQuantity;
                
                // Buat objek tiket
                $tempTicket = new \stdClass();
                $tempTicket->id = $ticketId;
                $tempTicket->name = $item['ticket_name'] ?? 'Tiket';
                $tempTicket->type = $item['ticket_type'] ?? '';
                $tempTicket->description = $item['ticket_description'] ?? '';
                $tempTicket->price = $itemPrice;
                
                // Tambahkan ke cartItems dengan data lengkap
                $cartItems[] = [
                    'ticket_id' => $ticketId,
                    'cart_key' => $cartKey,
                    'ticket' => $tempTicket,
                    'event' => $event,
                    'event_id' => $eventId,
                    'ticket_name' => $item['ticket_name'] ?? 'Tiket',
                    'ticket_type' => $item['ticket_type'] ?? '',
                    'ticket_description' => $item['ticket_description'] ?? '',
                    'quantity' => $itemQuantity,
                    'price' => $itemPrice,
                    'subtotal' => $itemSubtotal,
                ];
                
                // Update subtotal
                $subtotal += $itemSubtotal;
            }
            
            // Log hasil pemrosesan
            Log::debug('Checkout data processed', [
                'cart_items_count' => count($cartItems),
                'subtotal' => $subtotal,
                'events_count' => count($events),
                'event_ids' => array_keys($events)
            ]);
            
            // Get primary event for display
            $primaryEvent = !empty($events) ? reset($events) : null;
            
            // Simpan data untuk halaman sukses
            session()->put('checkout_events', $events);
            
            // Hitung pajak dan service fee
            $tax = round($subtotal * 0.11); // PPN 11%
            $serviceFee = 50000; // Fixed service fee
            $total = $subtotal + $tax + $serviceFee;
            
            // Return view dengan data yang diperlukan
            return view('frontend.pages.checkout', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'serviceFee' => $serviceFee,
                'total' => $total,
                'events' => $events,
                'primaryEvent' => $primaryEvent,
                'event' => $primaryEvent,  // For compatibility with existing templates
            ]);
            
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error processing checkout', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'cart' => $cart
            ]);
            
            // Clear session to prevent persistent errors
            session()->forget('cart');
            
            // Redirect with error message
            return redirect()->route('events')->with('error', 'Terjadi kesalahan saat memproses checkout. Silakan coba lagi.');
        }
    }
    
    /**
     * Show the checkout success page
     */
    public function checkoutSuccess()
    {
        // INISIALISASI DATA
        $defaultEvent = null;
        $eventId = session('checkout_event_id');
        $events = session('checkout_events', []);
        $orderItems = session('checkout_items', []);
        $showDebug = true; // Aktifkan debugging
        
        // DEBUGGING - SIMPAN SEMUA ISI SESSION KE DALAM VARIABEL
        $allSessionData = [
            'checkout_order_id' => session('checkout_order_id'),
            'checkout_order_number' => session('checkout_order_number'),
            'checkout_event_id' => session('checkout_event_id'),
            'checkout_items' => session('checkout_items'),
            'checkout_events' => session('checkout_events'),
            'checkout_subtotal' => session('checkout_subtotal'),
            'checkout_tax' => session('checkout_tax'),
            'checkout_service_fee' => session('checkout_service_fee'),
            'checkout_total' => session('checkout_total'),
            'checkout_date' => session('checkout_date'),
            'checkout_payment_status' => session('checkout_payment_status')
        ];
        
        // BUAT EVENT DUMMY YANG PASTI ADA
        $dummyEvent = (object) [
            'id' => 1,
            'title' => 'Konser KUY Festival',
            'date' => now(),
            'location' => 'Jakarta Convention Center',
            'poster_path' => null
        ];
        
        // DAPATKAN EVENT DARI SESSION JIKA ADA
        if (!empty($orderItems)) {
            foreach ($orderItems as $item) {
                if (isset($item['event']) && is_object($item['event'])) {
                    $defaultEvent = $item['event'];
                    break;
                }
            }
        }
        
        // JIKA MASIH TIDAK ADA, GUNAKAN DUMMY
        if (!$defaultEvent) {
            $defaultEvent = $dummyEvent;
        }
        
        // PASTIKAN SESSION UNTUK TEMPLATES LENGKAP
        if (empty($events)) {
            $events = [$defaultEvent->id => $defaultEvent];
        }
        
        return view('frontend.pages.checkout-success', [
            'event' => $defaultEvent,
            'events' => $events,
            'showDebug' => $showDebug,
            'allSessionData' => $allSessionData,
            'dummyEvent' => $dummyEvent
        ]);
    }
} 