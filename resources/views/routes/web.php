<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/events', [FrontendController::class, 'events'])->name('events');
Route::get('/events/{id}', [FrontendController::class, 'eventDetail'])->name('events.show');
Route::get('/categories', [FrontendController::class, 'categories'])->name('categories');
Route::get('/category/{slug}', [FrontendController::class, 'eventsByCategory'])->name('category.events');
Route::get('/venues', [FrontendController::class, 'venues'])->name('venues');
Route::get('/venues/{slug}', [FrontendController::class, 'showVenue'])->name('venues.show');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'contactSend'])->name('contact.send');
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('/terms', [FrontendController::class, 'terms'])->name('terms');
Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/help', [FrontendController::class, 'help'])->name('help');
Route::get('/about', [FrontendController::class, 'about'])->name('about');

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
    
    // Transaction Reports
    Route::get('/reports/transactions', [AdminController::class, 'transactionReports'])->name('reports.transactions');
    Route::get('/reports/export', [AdminController::class, 'exportReports'])->name('reports.export');
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
        return redirect()->route('organizer.dashboard');
    })->name('dashboard');
    
    // User Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // User Tickets
    Route::get('/tickets', [TicketController::class, 'dashboard'])->name('tickets.dashboard');
    Route::get('/tickets/history', [TicketController::class, 'history'])->name('tickets.history');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');
});
