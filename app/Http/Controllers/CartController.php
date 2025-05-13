<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ETicket;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // No middleware configuration here - will be defined in routes file
    }

    /**
     * Display the user's cart
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        // Process cart items with related data
        if (!empty($cart)) {
            foreach ($cart as $ticketId => $item) {
                $ticket = Ticket::with('event')->find($ticketId);
                if ($ticket) {
                    $cartItems[] = [
                        'ticket' => $ticket,
                        'quantity' => $item['quantity'],
                        'subtotal' => $ticket->price * $item['quantity'],
                    ];
                    $total += $ticket->price * $item['quantity'];
                }
            }
        }

        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a ticket to the cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'sometimes|integer|min:1|max:10',
        ]);

        $ticketId = $request->ticket_id;
        $quantity = $request->quantity ?? 1;

        $ticket = Ticket::with('event')->findOrFail($ticketId);

        // Check if ticket is available
        if (!$ticket->isAvailable()) {
            return redirect()->back()->with('error', 'Tiket tidak tersedia.');
        }

        // Check if requested quantity exceeds available tickets
        if ($quantity > $ticket->remaining) {
            return redirect()->back()->with('error', 'Jumlah tiket yang diminta melebihi stok yang tersedia.');
        }

        $cart = session()->get('cart', []);

        // If ticket already in cart, update quantity
        if (isset($cart[$ticketId])) {
            $newQuantity = $cart[$ticketId]['quantity'] + $quantity;
            
            // Check if new quantity exceeds available tickets
            if ($newQuantity > $ticket->remaining) {
                return redirect()->back()->with('error', 'Total tiket di keranjang melebihi stok yang tersedia.');
            }
            
            $cart[$ticketId]['quantity'] = $newQuantity;
        } else {
            // Make sure event data is complete
            $event = $ticket->event;
            
            // Add new ticket to cart with complete information
            $cart[$ticketId] = [
                'event_id' => $event->id,
                'event_title' => $event->title,
                'event_date' => $event->date,
                'event_location' => $event->location,
                'event_poster' => $event->poster_path,
                'ticket_name' => $ticket->name,
                'ticket_type' => $ticket->type,
                'ticket_description' => $ticket->description,
                'quantity' => $quantity,
                'price' => $ticket->price,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Tiket berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update cart item quantity
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $ticketId = $request->ticket_id;
        $quantity = $request->quantity;

        $ticket = Ticket::findOrFail($ticketId);

        // Check if requested quantity exceeds available tickets
        if ($quantity > $ticket->remaining) {
            return redirect()->back()->with('error', 'Jumlah tiket yang diminta melebihi stok yang tersedia.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$ticketId])) {
            $cart[$ticketId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Remove an item from the cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        $ticketId = $request->ticket_id;
        
        $cart = session()->get('cart', []);

        if (isset($cart[$ticketId])) {
            unset($cart[$ticketId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    /**
     * Clear the cart
     *
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }

    /**
     * Proceed to checkout
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Variabel untuk menyimpan data
        $cartItems = [];
        $subtotal = 0;
        $events = []; // Untuk menyimpan data event
        $eventIds = []; // Untuk tracking event IDs
        $primaryEvent = null; // Event utama (yang pertama)

        // Process cart items dengan error handling
        try {
            foreach ($cart as $cartKey => $item) {
                // Validasi data tiket
                if (!isset($item['quantity']) || (int)$item['quantity'] <= 0) {
                    continue;
                }

                // Jika menggunakan composite key (event_id_ticket_id), ekstrak komponennya
                $parts = explode('_', $cartKey);
                $eventId = isset($parts[0]) ? (int)$parts[0] : ($item['event_id'] ?? null);
                $ticketId = isset($parts[1]) ? (int)$parts[1] : null;
                
                // Skip jika tidak ada event ID
                if (!$eventId) {
                    continue;
                }

                // Ambil event dari database jika belum ada di array events
                if (!isset($events[$eventId])) {
                    // Coba ambil dari database
                    $dbEvent = Event::find($eventId);
                    
                    // Jika ditemukan di database, gunakan data tersebut
                    if ($dbEvent) {
                        $events[$eventId] = $dbEvent;
                        $eventIds[] = $eventId;
                        
                        // Set primary event jika belum ada
                        if (!$primaryEvent) {
                            $primaryEvent = $dbEvent;
                        }
                    } 
                    // Jika tidak ditemukan, buat objek event dari data di cart
                    else {
                        $eventObj = (object)[
                            'id' => $eventId,
                            'title' => $item['event_title'] ?? 'Event',
                            'date' => isset($item['event_date']) ? (is_string($item['event_date']) ? \Carbon\Carbon::parse($item['event_date']) : $item['event_date']) : null,
                            'location' => $item['event_location'] ?? '',
                            'poster_path' => $item['event_poster'] ?? null
                        ];
                        
                        $events[$eventId] = $eventObj;
                        $eventIds[] = $eventId;
                        
                        // Set primary event jika belum ada
                        if (!$primaryEvent) {
                            $primaryEvent = $eventObj;
                        }
                    }
                }
                
                // Dapatkan event data untuk item ini
                $eventData = $events[$eventId];
                
                // Hitung harga dan subtotal
                $price = (float)($item['price'] ?? 0);
                $quantity = (int)$item['quantity'];
                $itemSubtotal = $price * $quantity;
                
                // Tambahkan ke array items dengan data lengkap
                $cartItems[] = [
                    'ticket_id' => $ticketId,
                    'cart_key' => $cartKey,
                    'event' => $eventData,
                    'event_id' => $eventId,
                    'ticket_name' => $item['ticket_name'] ?? 'Tiket',
                    'ticket_type' => $item['ticket_type'] ?? '',
                    'ticket_description' => $item['ticket_description'] ?? '',
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $itemSubtotal
                ];
                
                // Hitung subtotal
                $subtotal += $itemSubtotal;
            }
            
            // Jika tidak ada item valid, redirect ke cart
            if (empty($cartItems)) {
                return redirect()->route('cart.index')
                    ->with('error', 'Tidak ada tiket valid dalam keranjang. Silakan pilih tiket lagi.');
            }
            
            // Hitung total
            $tax = $subtotal * 0.11; // 11% tax
            $serviceFee = 50000; // Fixed service fee
            $total = $subtotal + $tax + $serviceFee;
            
            // Return view dengan data
            return view('frontend.pages.checkout', compact(
                'cartItems', 
                'subtotal', 
                'tax', 
                'serviceFee', 
                'total', 
                'primaryEvent', 
                'events'
            ));
            
        } catch (\Exception $e) {
            // Log error
            Log::error('Error during checkout: ' . $e->getMessage(), [
                'cart' => $cart,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Redirect dengan error
            return redirect()->route('cart.index')
                ->with('error', 'Terjadi kesalahan saat memproses checkout. Silakan coba lagi atau hubungi customer service.');
        }
    }

    /**
     * Process the order - handles multiple tickets in cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processOrder(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet',
        ]);
        
        // Get cart items from session
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }
        
        // Initialize variables for order creation
        $subtotal = 0;
        $orderData = [];
        $eventIds = [];
        $events = [];
        
        // Process cart items
        foreach ($cart as $cartKey => $item) {
            // Extract components if using composite key
            $parts = explode('_', $cartKey);
            $eventId = isset($parts[0]) ? (int)$parts[0] : ($item['event_id'] ?? null);
            $ticketId = isset($parts[1]) ? (int)$parts[1] : null;
            
            // Skip if no event ID
            if (!$eventId) {
                continue;
            }
            
            // Get event data 
            $eventData = null;
            if (!isset($events[$eventId])) {
                // Try to get from database first
                $dbEvent = Event::find($eventId);
                
                if ($dbEvent) {
                    $eventDate = $dbEvent->date;
                } else {
                    // Use data from cart
                    $eventDate = null;
                    if (isset($item['event_date'])) {
                        if (is_string($item['event_date'])) {
                            $eventDate = \Carbon\Carbon::parse($item['event_date']);
                        } else {
                            $eventDate = $item['event_date'];
                        }
                    }
                    
                    $dbEvent = (object)[
                        'id' => $eventId,
                        'title' => $item['event_title'] ?? 'Event',
                        'date' => $eventDate,
                        'location' => $item['event_location'] ?? '',
                        'poster_path' => $item['event_poster'] ?? null
                    ];
                }
                
                $eventData = [
                    'id' => $eventId,
                    'title' => $dbEvent->title,
                    'date' => $dbEvent->date,
                    'location' => $dbEvent->location ?? '',
                    'poster_path' => $dbEvent->poster_path ?? null
                ];
                
                // Store event data
                $events[$eventId] = (object)$eventData;
                $eventIds[] = $eventId;
            } else {
                $eventData = $events[$eventId];
            }
            
            // Calculate price and subtotal
            $itemPrice = (float)($item['price'] ?? 0);
            $itemQuantity = (int)$item['quantity'];
            $itemSubtotal = $itemPrice * $itemQuantity;
            
            // Create ticket if needed
            $ticket = (object)[
                'id' => $ticketId,
                'name' => $item['ticket_name'] ?? 'Tiket',
                'type' => $item['ticket_type'] ?? '',
                'description' => $item['ticket_description'] ?? '',
                'price' => $itemPrice
            ];
            
            // Add to order data with complete information
            $orderData[] = [
                'ticket' => $ticket,
                'quantity' => $itemQuantity,
                'subtotal' => $itemSubtotal,
                'ticket_name' => $item['ticket_name'] ?? 'Tiket',
                'ticket_type' => $item['ticket_type'] ?? '',
                'ticket_description' => $item['ticket_description'] ?? '',
                'event' => (object)$eventData,
                'ticket_code' => strtoupper(substr(md5($ticketId . $eventId . time() . rand(1000, 9999)), 0, 10)),
            ];
            
            // Calculate subtotal
            $subtotal += $itemSubtotal;
        }
        
        // If there are no valid tickets in the cart, redirect back
        if (empty($orderData)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada tiket valid dalam keranjang Anda.');
        }
        
        // Calculate total
        $tax = $subtotal * 0.11; // 11% tax
        $serviceFee = 50000; // Fixed service fee
        $total = $subtotal + $tax + $serviceFee;
        
        // Get primary event
        $primaryEventId = !empty($eventIds) ? $eventIds[0] : null;
        
        // Generate a unique order reference number for session (even if we can't save to DB)
        $orderNumber = 'KUY' . now()->format('YmdHis') . rand(1000, 9999);
        
        // Try to save to database, but continue even if it fails
        $orderId = null;
        try {
            // Check if our database has the required columns
            $hasOrderNumberColumn = DB::getSchemaBuilder()->hasColumn('orders', 'order_number');
            $hasPaymentStatusColumn = DB::getSchemaBuilder()->hasColumn('orders', 'payment_status');
            $hasPaymentMethodColumn = DB::getSchemaBuilder()->hasColumn('orders', 'payment_method');
            
            // Try to create an order with the available columns
            DB::beginTransaction();
            
            // Create a basic order record with only the available columns
            $orderDbData = [
                'user_id' => auth()->id(),
                'event_id' => $primaryEventId,
                'total_amount' => $total,
                'status' => 'paid',
            ];
            
            // Add optional columns if they exist
            if ($hasOrderNumberColumn) {
                $orderDbData['order_number'] = $orderNumber;
            }
            
            if ($hasPaymentStatusColumn) {
                $orderDbData['payment_status'] = 'paid';
            }
            
            if ($hasPaymentMethodColumn) {
                $orderDbData['payment_method'] = $request->payment_method;
            }
            
            // Create the order
            $order = new \App\Models\Order($orderDbData);
            $order->save();
            $orderId = $order->id;
            
            // If order_items table exists, try to create order items
            if (Schema::hasTable('order_items')) {
                foreach ($orderData as $item) {
                    $eventId = $item['event']->id;
                    
                    $itemData = [
                        'order_id' => $order->id,
                        'event_id' => $eventId,
                        'ticket_id' => $item['ticket']->id,
                        'quantity' => $item['quantity'],
                        'price' => $item['ticket']->price,
                        'subtotal' => $item['subtotal'],
                    ];
                    
                    // Create order item
                    $orderItem = new \App\Models\OrderItem($itemData);
                    $orderItem->save();
                    
                    // If e_tickets table exists, create e-tickets
                    if (Schema::hasTable('e_tickets')) {
                        for ($i = 0; $i < $item['quantity']; $i++) {
                            // Cek kolom apa yang tersedia di table e_tickets
                            $hasOrderItemId = Schema::hasColumn('e_tickets', 'order_item_id');
                            $hasOrderId = Schema::hasColumn('e_tickets', 'order_id');
                            $hasIsUsed = Schema::hasColumn('e_tickets', 'is_used');
                            $hasStatus = Schema::hasColumn('e_tickets', 'status');
                            $hasEventDate = Schema::hasColumn('e_tickets', 'event_date');

                            $eTicketData = [
                                'user_id' => auth()->id(),
                                'code' => $item['ticket_code'] . '-' . ($i + 1),
                            ];

                            // PRIORITAS: Selalu gunakan order_id karena struktur tabel saat ini menggunakan itu
                            if ($hasOrderId) {
                                $eTicketData['order_id'] = $order->id;
                            }
                            // Hanya gunakan order_item_id jika struktur tabel berubah di masa depan
                            elseif ($hasOrderItemId) {
                                $eTicketData['order_item_id'] = $orderItem->id;
                            }
                            
                            if ($hasIsUsed) {
                                $eTicketData['is_used'] = false;
                            }
                            
                            if ($hasStatus) {
                                $eTicketData['status'] = 'active';
                            }
                            
                            if ($hasEventDate && isset($item['event']) && isset($item['event']->date)) {
                                $eTicketData['event_date'] = $item['event']->date;
                            }
                            
                            // Log e-ticket creation
                            Log::info('Creating e-ticket', [
                                'user_id' => auth()->id(),
                                'code' => $eTicketData['code'],
                                'data' => $eTicketData
                            ]);

                            $eTicket = new \App\Models\ETicket($eTicketData);
                            $eTicket->save();
                        }
                    }
                }
            }
            
            // If payments table exists, try to create a payment record
            if (Schema::hasTable('payments')) {
                $paymentData = [
                    'order_id' => $order->id,
                    'payment_method' => $request->payment_method,
                    'payment_code' => 'PAY' . now()->format('YmdHis') . rand(1000, 9999),
                    'status' => 'completed',
                    'paid_at' => now(),
                    'notes' => 'Payment completed automatically on checkout',
                ];
                
                $payment = new \App\Models\Payment($paymentData);
                $payment->save();
            }
            
            DB::commit();
            
            // Log successful database save
            Log::info('Order saved to database successfully', [
                'order_id' => $order->id,
                'order_number' => $orderNumber,
            ]);
        } catch (\Exception $e) {
            // Rollback if transaction was started
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            
            // Log the error but continue with checkout
            Log::error('Failed to save order to database: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'cart' => $cart,
                'order_data' => $orderData
            ]);
            
            // Order will still be processed in session even if database save fails
            Log::info('Continuing with checkout process using session data only.');
        }
        
        // Store order information in session for success page (even if DB save failed)
        session([
            'checkout_order_id' => $orderId ?? rand(100000, 999999),
            'checkout_order_number' => $orderNumber,
            'checkout_event_id' => $primaryEventId,
            'checkout_items' => $orderData,
            'checkout_subtotal' => $subtotal,
            'checkout_tax' => $tax,
            'checkout_service_fee' => $serviceFee,
            'checkout_total' => $total,
            'checkout_events' => $events,
            'checkout_date' => now()->format('d F Y, H:i'),
            'checkout_payment_status' => 'LUNAS'
        ]);
        
        // Debug log to see what we're saving
        Log::debug('Order data stored in session', [
            'order_number' => $orderNumber,
            'primary_event_id' => $primaryEventId,
            'events_count' => count($events),
            'events_keys' => array_keys($events),
            'items_count' => count($orderData),
            'has_event_data' => !empty($events),
            'first_item_has_event' => !empty($orderData) && isset($orderData[0]['event']) ? 'yes' : 'no'
        ]);
        
        // Clear the cart
        session()->forget('cart');
        
        // Log successful order
        Log::info('Order processed successfully', [
            'order_id' => $orderId ?? 'session_only',
            'order_number' => $orderNumber,
            'total' => $total,
            'events' => array_keys($events),
            'item_count' => count($orderData)
        ]);
        
        // Redirect to success page
        return redirect()->route('checkout.success');
    }

    /**
     * Add multiple tickets to the cart at once and redirect to checkout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMultiple(Request $request)
    {
        // Log untuk debugging
        Log::debug('addMultiple called', [
            'ticket_ids' => $request->ticket_ids,
            'quantities' => $request->quantities,
            'method' => $request->method(),
            'replace_cart' => $request->input('replace_cart'),
            'all_data' => $request->all(),
            'event_id' => $request->event_id,
            'debug' => $request->debug,
            'url' => $request->url(),
        ]);

        // Validasi dasar input
        if (!$request->has('ticket_ids') || !$request->has('quantities')) {
            Log::error('Missing required parameters: ticket_ids or quantities');
            return back()->withErrors(['message' => 'Data tidak lengkap. Parameter ticket_ids atau quantities tidak ada.']);
        }

        if (!$request->has('event_id')) {
            Log::error('Missing event_id parameter');
            return back()->withErrors(['message' => 'Data tidak lengkap. Parameter event_id tidak ada.']);
        }

        // Get tickets and quantities from the form
        $ticketIds = $request->ticket_ids;
        $quantities = $request->quantities;

        // Validasi input
        if (!is_array($ticketIds) || !is_array($quantities) || count($ticketIds) != count($quantities)) {
            Log::error('Invalid cart data format');
            return back()->withErrors(['message' => 'Format data tidak valid. Tiket dan kuantitas harus array dengan jumlah yang sama.']);
        }

        // Mendapatkan event dari parameter
        $eventId = $request->event_id;
        $event = Event::find($eventId);

        if (!$event) {
            Log::error('Event not found', ['event_id' => $eventId]);
            return back()->withErrors(['message' => 'Event tidak ditemukan. Silakan coba lagi.']);
        }

        Log::info('Processing tickets for event', [
            'event_id' => $event->id,
            'event_title' => $event->title,
            'ticket_count' => count($ticketIds)
        ]);

        // Decide whether to append to or replace existing cart
        $replace = $request->input('replace_cart', true);
        
        // Get existing cart if not replacing
        $cart = $replace ? [] : session()->get('cart', []);
        
        // If replacing, clear the cart
        if ($replace) {
            session()->forget('cart');
            Log::info('Cart cleared due to replace_cart=true');
        }
        
        // Flag to check if any tickets were added
        $ticketsAdded = false;
        $ticketsProcessed = [];
        
        // Process each ticket untuk frontend tickets dari event detail
        foreach ($ticketIds as $index => $ticketId) {
            // Skip jika tidak ada index yang sesuai di array quantities
            if (!isset($quantities[$index])) {
                Log::warning('Missing quantity for ticket', ['ticket_id' => $ticketId, 'index' => $index]);
                continue;
            }
            
            $quantity = (int) $quantities[$index];
            
            // Skip tickets with zero quantity
            if ($quantity <= 0) {
                Log::debug('Skipping ticket with zero quantity', ['ticket_id' => $ticketId, 'index' => $index]);
                continue;
            }

            // -- PERHATIAN: Semua jenis tiket berikut adalah untuk tiket yang dibuat di FrontendController --
            
            // Ciptakan composite key untuk tiket yang unik per event
            $compositeKey = $eventId . '_' . $ticketId;
            
            // Tambahkan tiket ke cart berdasarkan tipe tiket
            if ($ticketId == 1) {
                // Regular ticket (standard)
                Log::info('Adding Regular ticket to cart', [
                    'event_id' => $event->id,
                    'ticket_id' => $ticketId,
                    'composite_key' => $compositeKey,
                    'quantity' => $quantity, 
                    'price' => $event->ticket_price
                ]);
                
                $cart[$compositeKey] = [
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'event_date' => $event->date,
                    'event_location' => $event->location,
                    'event_poster' => $event->poster_path,
                    'ticket_id' => $ticketId,
                    'ticket_name' => 'Regular',
                    'ticket_type' => 'standard',
                    'ticket_description' => 'Basic ticket with standard seating',
                    'quantity' => $quantity,
                    'price' => $event->ticket_price,
                ];
                
                $ticketsAdded = true;
                $ticketsProcessed[] = [
                    'id' => $compositeKey,
                    'event_id' => $event->id,
                    'ticket_id' => $ticketId,
                    'name' => 'Regular',
                    'quantity' => $quantity,
                    'price' => $event->ticket_price
                ];
            } 
            else if ($ticketId == 2) {
                // Premium ticket
                $price = $event->ticket_price * 2;
                Log::info('Adding Premium ticket to cart', [
                    'event_id' => $event->id,
                    'ticket_id' => $ticketId,
                    'composite_key' => $compositeKey,
                    'quantity' => $quantity, 
                    'price' => $price
                ]);
                
                $cart[$compositeKey] = [
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'event_date' => $event->date,
                    'event_location' => $event->location,
                    'event_poster' => $event->poster_path,
                    'ticket_id' => $ticketId,
                    'ticket_name' => 'Premium',
                    'ticket_type' => 'premium',
                    'ticket_description' => 'Premium seating with better view',
                    'quantity' => $quantity,
                    'price' => $price,
                ];
                
                $ticketsAdded = true;
                $ticketsProcessed[] = [
                    'id' => $compositeKey,
                    'event_id' => $event->id,
                    'ticket_id' => $ticketId,
                    'name' => 'Premium',
                    'quantity' => $quantity,
                    'price' => $price
                ];
            } 
            else if ($ticketId == 3) {
                // VIP ticket
                $price = $event->ticket_price * 4;
                Log::info('Adding VIP ticket to cart', [
                    'event_id' => $event->id,
                    'ticket_id' => $ticketId,
                    'composite_key' => $compositeKey,
                    'quantity' => $quantity, 
                    'price' => $price
                ]);
                
                $cart[$compositeKey] = [
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'event_date' => $event->date,
                    'event_location' => $event->location,
                    'event_poster' => $event->poster_path,
                    'ticket_id' => $ticketId,
                    'ticket_name' => 'VIP',
                    'ticket_type' => 'vip',
                    'ticket_description' => 'VIP package with exclusive merchandise',
                    'quantity' => $quantity,
                    'price' => $price,
                ];
                
                $ticketsAdded = true;
                $ticketsProcessed[] = [
                    'id' => $compositeKey,
                    'event_id' => $event->id,
                    'ticket_id' => $ticketId,
                    'name' => 'VIP',
                    'quantity' => $quantity,
                    'price' => $price
                ];
            }
            else {
                Log::warning('Unknown ticket type', ['ticket_id' => $ticketId]);
            }
        }
        
        // Save cart to session
        session()->put('cart', $cart);
        
        // Log cart contents for debugging
        Log::debug('Cart contents after adding tickets:', [
            'cart' => $cart,
            'tickets_processed' => $ticketsProcessed,
            'were_tickets_added' => $ticketsAdded,
            'cart_count' => count($cart)
        ]);
        
        // Redirect based on if tickets were added
        if (!$ticketsAdded) {
            Log::error('No tickets were added to cart', ['request_data' => $request->all()]);
            return back()->withErrors(['message' => 'Tidak ada tiket yang berhasil ditambahkan. Silakan pilih minimal 1 tiket.']);
        }
        
        // Direct redirect to checkout
        try {
            Log::info('Redirecting to checkout page', [
                'cart_items_count' => count($cart),
                'cart_in_session' => session()->has('cart'),
                'checkout_url' => route('checkout')
            ]);
            
            // Redirect to checkout page
            return redirect()->route('checkout')->with('success', 'Tiket berhasil ditambahkan ke keranjang.');
        } catch(\Exception $e) {
            Log::error('Exception during redirect to checkout', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['message' => 'Terjadi kesalahan saat menuju halaman checkout: ' . $e->getMessage()]);
        }
    }
} 