<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketViewController;
use Illuminate\Support\Facades\Auth;

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/events', [FrontendController::class, 'events'])->name('events');
Route::get('/events/{slug}', [FrontendController::class, 'eventDetail'])->name('events.show');
Route::get('/categories', [FrontendController::class, 'categories'])->name('categories');
Route::get('/category/{slug}', [FrontendController::class, 'showCategory'])->name('categories.show');
Route::get('/venues', [FrontendController::class, 'venues'])->name('venues');
Route::get('/venue/{slug}', [FrontendController::class, 'showVenue'])->name('venues.show');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'contactSend'])->name('contact.send');
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('/terms', [FrontendController::class, 'terms'])->name('terms');
Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/help', [FrontendController::class, 'help'])->name('help');

// Route spesifik untuk Pantai Clumik
Route::get('/venue/pantai-clumik-jepara', function() {
    return redirect()->route('venues.show', 'pantai-clumik');
});

// Cart & Checkout
Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
Route::get('/checkout/success', [FrontendController::class, 'checkoutSuccess'])->name('checkout.success');
Route::post('/checkout/process', [CartController::class, 'processOrder'])->name('checkout.process');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/add-multiple', [CartController::class, 'addMultiple'])->name('add-multiple');
    Route::get('/add-multiple', function() {
        return redirect()->route('events')->with('error', 'Metode GET tidak didukung untuk checkout. Silakan gunakan form di halaman detail event.');
    });
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::get('/clear', [CartController::class, 'clear'])->name('clear');
});

// Payment Routes (need authentication)
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{id}/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
    Route::get('/payment/{id}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');
    Route::get('/payment/ticket/{id}', [PaymentController::class, 'ticketDetails'])->name('payment.ticket');
    
    // Debug route
    Route::get('/debug-ticket/{id}', [PaymentController::class, 'debugTicket'])->name('debug.ticket');
    
    // New simplified ticket routes
    Route::get('/ticket', [TicketViewController::class, 'index'])->name('ticket.index');
    Route::get('/ticket/{id}', [TicketViewController::class, 'show'])->name('ticket.view');
});

// Admin Routes
Route::middleware(['auth:sanctum', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::put('/users/{user}/update-role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::put('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Events Validation
    Route::get('/events/validation', [AdminController::class, 'eventsValidation'])->name('events.validation');
    Route::get('/events/{event}', [AdminController::class, 'showEvent'])->name('events.show');
    Route::put('/events/{event}/approve', [AdminController::class, 'approveEvent'])->name('events.approve');
    Route::put('/events/{event}/reject', [AdminController::class, 'rejectEvent'])->name('events.reject');
    
    // Reports
    Route::get('/reports/transactions', [App\Http\Controllers\Admin\ReportController::class, 'transactions'])->name('reports.transactions');
    Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
});

// Event Organizer Routes
Route::middleware(['auth:sanctum', 'verified'])->prefix('organizer')->name('organizer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [OrganizerController::class, 'dashboard'])->name('dashboard');
    
    // Event Management
    Route::get('/events', [OrganizerController::class, 'events'])->name('events.index');
    Route::get('/events/create', [OrganizerController::class, 'createEvent'])->name('events.create');
    Route::post('/events', [OrganizerController::class, 'storeEvent'])->name('events.store');
    Route::get('/events/{event}', [OrganizerController::class, 'showEvent'])->name('events.show');
    Route::get('/events/{event}/edit', [OrganizerController::class, 'editEvent'])->name('events.edit');
    Route::put('/events/{event}', [OrganizerController::class, 'updateEvent'])->name('events.update');
    Route::delete('/events/{event}', [OrganizerController::class, 'destroyEvent'])->name('events.destroy');
    
    // Ticket Management
    Route::get('/events/{event}/tickets', [OrganizerController::class, 'tickets'])->name('tickets.index');
    Route::post('/events/{event}/tickets', [OrganizerController::class, 'storeTicket'])->name('tickets.store');
    Route::get('/events/{event}/tickets/{ticket}/edit', [OrganizerController::class, 'editTicket'])->name('tickets.edit');
    Route::put('/events/{event}/tickets/{ticket}', [OrganizerController::class, 'updateTicket'])->name('tickets.update');
    Route::delete('/events/{event}/tickets/{ticket}', [OrganizerController::class, 'destroyTicket'])->name('tickets.destroy');
    
    // Order Management
    Route::get('/orders', [OrganizerController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}/detail', [OrganizerController::class, 'orderDetail'])->name('orders.detail');
    Route::get('/orders/export', [OrganizerController::class, 'exportOrders'])->name('orders.export');
});

// Regular User Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'eo') {
            return redirect()->route('organizer.dashboard');
        } else {
            // Regular user dashboard
            return view('dashboard');
        }
    })->name('dashboard');
    
    // Ticket Hub Page
    Route::get('/tickets-hub', function() {
        return view('ticket-hub');
    })->name('tickets.hub');
    
    // User Tickets
    Route::get('/tickets', [TicketController::class, 'dashboard'])->name('tickets.dashboard');
    Route::get('/tickets/history', [TicketController::class, 'history'])->name('tickets.history');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');
});

// Dummy Data Route (for testing)
Route::get('/create-dummy-event', [App\Http\Controllers\DummyDataController::class, 'createDummyEvent'])->name('create.dummy.event');
