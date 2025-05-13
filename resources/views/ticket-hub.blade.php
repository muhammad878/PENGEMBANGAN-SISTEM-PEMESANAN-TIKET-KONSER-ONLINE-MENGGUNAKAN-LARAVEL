@php
    use Illuminate\Support\Facades\Route;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tiket & Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Success Notice -->
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="p-6">
                    <!-- Debug Information (only visible to admins) -->
                    @if(auth()->user() && auth()->user()->role == 'admin')
                    <div class="bg-gray-100 p-4 mb-6 rounded-lg text-xs">
                        <h4 class="font-bold mb-2">Debug Info</h4>
                        <p>User ID: {{ auth()->id() }}</p>
                        <p>Available Routes:</p>
                        @php
                            $ticketIndexExists = Route::has('ticket.index');
                            $ticketViewExists = Route::has('ticket.view');
                            $ticketsIndexExists = Route::has('tickets.index');
                            $ticketsShowExists = Route::has('tickets.show');
                            $paymentHistoryExists = Route::has('payment.history');
                        @endphp
                        <ul class="list-disc ml-4">
                            <li>ticket.index: {{ $ticketIndexExists ? 'Yes' : 'No' }}</li>
                            <li>ticket.view: {{ $ticketViewExists ? 'Yes' : 'No' }}</li>
                            <li>tickets.index: {{ $ticketsIndexExists ? 'Yes' : 'No' }}</li>
                            <li>tickets.show: {{ $ticketsShowExists ? 'Yes' : 'No' }}</li>
                            <li>payment.history: {{ $paymentHistoryExists ? 'Yes' : 'No' }}</li>
                        </ul>
                    </div>
                    @endif
                    
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Akses Cepat Fitur Pembayaran</h3>
                    
                    <div class="grid grid-cols-1 gap-6 mb-8">
                        <!-- Payment History -->
                        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100 relative">
                            <!-- Active badge -->
                            <div class="absolute top-4 right-4">
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full uppercase tracking-wide font-semibold">Aktif</span>
                            </div>
                            
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <h4 class="text-lg font-medium text-gray-900">Riwayat Pembayaran & Tiket</h4>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Lihat riwayat pembayaran dan akses tiket Anda secara lengkap.
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4 flex space-x-3">
                                    <a href="{{ route('payment.history') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Riwayat Pembayaran
                                    </a>
                                    <a href="{{ route('ticket.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        Akses Tiket
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment History Quick View -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Pembayaran Terbaru</h3>
                        
                        @php
                            try {
                                $recentOrders = auth()->user()->orders()->with(['payment', 'eTickets'])->latest()->take(3)->get();
                            } catch (\Exception $e) {
                                $recentOrders = collect([]);
                                \Illuminate\Support\Facades\Log::error('Error loading recent orders: ' . $e->getMessage());
                            }
                        @endphp
                        
                        @if($recentOrders->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentOrders as $order)
                                    <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100">
                                        <div class="px-4 py-5 sm:p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="text-lg font-medium text-gray-900">
                                                    Pesanan #{{ $order->order_number }}
                                                </div>
                                                <div>
                                                    @if($order->payment_status == 'pending')
                                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Menunggu Pembayaran</span>
                                                    @elseif($order->payment_status == 'processing')
                                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Sedang Diproses</span>
                                                    @elseif($order->payment_status == 'paid')
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Sukses</span>
                                                    @elseif($order->payment_status == 'failed')
                                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Gagal</span>
                                                    @else
                                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">{{ $order->payment_status }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="text-sm text-gray-500 mb-4">
                                                <p><span class="font-medium">Tanggal:</span> {{ $order->created_at->format('d F Y, H:i') }}</p>
                                                <p class="mt-1"><span class="font-medium">Total:</span> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                                <p class="mt-1">
                                                    <span class="font-medium">Metode Pembayaran:</span> 
                                                    @if($order->payment_method == 'bank_transfer')
                                                        Transfer Bank
                                                    @elseif($order->payment_method == 'e_wallet')
                                                        E-Wallet
                                                    @elseif($order->payment_method == 'credit_card')
                                                        Kartu Kredit
                                                    @else
                                                        {{ $order->payment_method ?? 'Tidak Tersedia' }}
                                                    @endif
                                                </p>
                                            </div>
                                            
                                            <div class="mt-4">
                                                <a href="{{ route('payment.history') }}#order-{{ $order->id }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                    Lihat Detail
                                                </a>
                                                @if($order->payment_status == 'paid' && isset($order->eTickets) && $order->eTickets->count() > 0)
                                                    <a href="{{ route('ticket.view', $order->eTickets->first()->id) }}" class="inline-flex items-center ml-2 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700">
                                                        Lihat Tiket
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 text-center">
                                <a href="{{ route('payment.history') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Lihat Semua Pembayaran
                                </a>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-6 text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-4">
                                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-base font-medium text-gray-900 mb-1">Belum Ada Riwayat Pembayaran</h4>
                                <p class="text-sm text-gray-500 mb-4">Anda belum memiliki riwayat pembayaran untuk ditampilkan.</p>
                                <a href="{{ route('events') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700">
                                    Jelajahi Konser
                                </a>
                                
                                <!-- Direct Access to Tickets -->
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-medium text-gray-700 mb-2">Akses Langsung ke Tiket</h4>
                                    <p class="text-sm text-gray-500 mb-3">Jika Anda mengalami kesulitan mengakses tiket melalui halaman ini, silahkan gunakan link alternatif:</p>
                                    <div class="flex flex-wrap gap-2 justify-center">
                                        <a href="{{ route('ticket.index') }}" class="text-sm px-3 py-1 bg-pink-600 text-white rounded hover:bg-pink-700">Lihat Tiket Baru</a>
                                        @php
                                            $hasTicketsIndex = Route::has('tickets.index');
                                            $hasTicketsDashboard = Route::has('tickets.dashboard');
                                        @endphp
                                        @if($hasTicketsIndex)
                                            <a href="{{ route('tickets.index') }}" class="text-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Lihat Tiket Legacy</a>
                                        @endif
                                        @if($hasTicketsDashboard)
                                            <a href="{{ route('tickets.dashboard') }}" class="text-sm px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700">Dashboard Tiket</a>
                                        @endif
                                        <a href="{{ route('payment.history') }}" class="text-sm px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Riwayat Pembayaran</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- All Payments and Tickets View -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Semua Pembayaran & Tiket</h3>
                        
                        @php
                            try {
                                $allOrders = auth()->user()->orders()->with(['payment', 'eTickets.orderItem', 'eTickets.user'])->latest()->get();
                                $allTickets = auth()->user()->eTickets()->with(['order', 'orderItem'])->latest()->get();
                            } catch (\Exception $e) {
                                $allOrders = collect([]);
                                $allTickets = collect([]);
                                \Illuminate\Support\Facades\Log::error('Error loading all orders and tickets: ' . $e->getMessage());
                            }
                        @endphp
                        
                        @if($allOrders->count() > 0 || $allTickets->count() > 0)
                            <!-- Payments -->
                            @if($allOrders->count() > 0)
                                <div class="mb-6">
                                    <h4 class="text-md font-medium text-gray-700 mb-3">Pembayaran ({{ $allOrders->count() }})</h4>
                                    <div class="space-y-4">
                                        @foreach($allOrders as $order)
                                            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100">
                                                <div class="px-4 py-5 sm:p-6">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <div class="text-lg font-medium text-gray-900">
                                                            Pesanan #{{ $order->order_number }}
                                                        </div>
                                                        <div>
                                                            @if($order->payment_status == 'pending')
                                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Menunggu Pembayaran</span>
                                                            @elseif($order->payment_status == 'processing')
                                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Sedang Diproses</span>
                                                            @elseif($order->payment_status == 'paid')
                                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Sukses</span>
                                                            @elseif($order->payment_status == 'failed')
                                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Gagal</span>
                                                            @else
                                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">{{ $order->payment_status }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="text-sm text-gray-500 mb-3">
                                                        <p><span class="font-medium">Tanggal:</span> {{ $order->created_at->format('d F Y, H:i') }}</p>
                                                        <p class="mt-1"><span class="font-medium">Total:</span> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                                        <p class="mt-1">
                                                            <span class="font-medium">Metode Pembayaran:</span> 
                                                            @if($order->payment_method == 'bank_transfer')
                                                                Transfer Bank
                                                            @elseif($order->payment_method == 'e_wallet')
                                                                E-Wallet
                                                            @elseif($order->payment_method == 'credit_card')
                                                                Kartu Kredit
                                                            @else
                                                                {{ $order->payment_method ?? 'Tidak Tersedia' }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <!-- Related Tickets -->
                                                    @if(isset($order->eTickets) && $order->eTickets->count() > 0)
                                                        <div class="mt-3 mb-4">
                                                            <h5 class="text-sm font-medium text-gray-700 mb-2">Tiket Terkait:</h5>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                                @foreach($order->eTickets as $ticket)
                                                                    <div class="bg-gray-50 border border-gray-200 rounded-md p-3">
                                                                        <div class="flex justify-between items-center">
                                                                            <div class="text-sm font-medium">{{ $ticket->code }}</div>
                                                                            <div>
                                                                                @if(isset($ticket->status) && $ticket->status == 'active' || (!isset($ticket->status) && (!isset($ticket->is_used) || !$ticket->is_used)))
                                                                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aktif</span>
                                                                                @elseif(isset($ticket->status) && $ticket->status == 'used' || (isset($ticket->is_used) && $ticket->is_used))
                                                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Terpakai</span>
                                                                                @elseif(isset($ticket->status) && $ticket->status == 'expired')
                                                                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Kadaluarsa</span>
                                                                                @else
                                                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Unknown</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-2 text-xs text-gray-500">
                                                                            @php
                                                                                $eventName = '';
                                                                                $eventDate = '';
                                                                                
                                                                                // Try to get event info from different relations
                                                                                if (isset($ticket->order) && isset($ticket->order->event)) {
                                                                                    $eventName = $ticket->order->event->title ?? '';
                                                                                    if (isset($ticket->order->event->date)) {
                                                                                        $eventDate = \Carbon\Carbon::parse($ticket->order->event->date)->format('d M Y, H:i');
                                                                                    }
                                                                                } elseif (isset($ticket->orderItem) && isset($ticket->orderItem->event)) {
                                                                                    $eventName = $ticket->orderItem->event->title ?? '';
                                                                                    if (isset($ticket->orderItem->event->date)) {
                                                                                        $eventDate = \Carbon\Carbon::parse($ticket->orderItem->event->date)->format('d M Y, H:i');
                                                                                    }
                                                                                } elseif (isset($ticket->event_date)) {
                                                                                    $eventDate = \Carbon\Carbon::parse($ticket->event_date)->format('d M Y, H:i');
                                                                                }
                                                                            @endphp
                                                                            
                                                                            @if(!empty($eventName))
                                                                                <p class="mb-1"><span class="font-medium">Event:</span> {{ $eventName }}</p>
                                                                            @endif
                                                                            
                                                                            @if(!empty($eventDate))
                                                                                <p class="mb-1"><span class="font-medium">Tanggal:</span> {{ $eventDate }}</p>
                                                                            @endif
                                                                        </div>
                                                                        <div class="mt-2">
                                                                            <a href="{{ route('ticket.view', $ticket->id) }}" class="text-sm text-pink-600 hover:text-pink-800">Lihat Tiket</a>
                                                                            @php
                                                                                $hasTicketsShow = Route::has('tickets.show');
                                                                            @endphp
                                                                            @if($hasTicketsShow)
                                                                                <a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-blue-600 hover:text-blue-800 ml-3">Tiket Alternatif</a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    <div class="mt-4">
                                                        <a href="{{ route('payment.history') }}#order-{{ $order->id }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                            Lihat Detail Pembayaran
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Tickets without Orders (if any) -->
                            @php
                                try {
                                    $ticketsWithoutOrders = $allTickets->filter(function($ticket) {
                                        return !isset($ticket->order_id) || !$ticket->order_id;
                                    });
                                } catch (\Exception $e) {
                                    $ticketsWithoutOrders = collect([]);
                                    \Illuminate\Support\Facades\Log::error('Error filtering tickets: ' . $e->getMessage());
                                }
                            @endphp
                            
                            @if($ticketsWithoutOrders->count() > 0)
                                <div class="mt-6">
                                    <h4 class="text-md font-medium text-gray-700 mb-3">Tiket Lainnya ({{ $ticketsWithoutOrders->count() }})</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($ticketsWithoutOrders as $ticket)
                                            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100">
                                                <div class="px-4 py-5 sm:p-6">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <div class="text-lg font-medium text-gray-900">
                                                            Tiket #{{ $ticket->code }}
                                                        </div>
                                                        <div>
                                                            @if(isset($ticket->status) && $ticket->status == 'active' || (!isset($ticket->status) && (!isset($ticket->is_used) || !$ticket->is_used)))
                                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aktif</span>
                                                            @elseif(isset($ticket->status) && $ticket->status == 'used' || (isset($ticket->is_used) && $ticket->is_used))
                                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Terpakai</span>
                                                            @elseif(isset($ticket->status) && $ticket->status == 'expired')
                                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Kadaluarsa</span>
                                                            @else
                                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Unknown</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- More ticket information -->
                                                    <div class="mt-2 text-sm text-gray-500">
                                                        @php
                                                            $eventName = '';
                                                            $eventDate = '';
                                                            
                                                            // Try to get event info from different relations
                                                            if (isset($ticket->order) && isset($ticket->order->event)) {
                                                                $eventName = $ticket->order->event->title ?? '';
                                                                if (isset($ticket->order->event->date)) {
                                                                    $eventDate = \Carbon\Carbon::parse($ticket->order->event->date)->format('d M Y, H:i');
                                                                }
                                                            } elseif (isset($ticket->orderItem) && isset($ticket->orderItem->event)) {
                                                                $eventName = $ticket->orderItem->event->title ?? '';
                                                                if (isset($ticket->orderItem->event->date)) {
                                                                    $eventDate = \Carbon\Carbon::parse($ticket->orderItem->event->date)->format('d M Y, H:i');
                                                                }
                                                            } elseif (isset($ticket->event_date)) {
                                                                $eventDate = \Carbon\Carbon::parse($ticket->event_date)->format('d M Y, H:i');
                                                            }
                                                        @endphp
                                                        
                                                        @if(!empty($eventName))
                                                            <p class="mb-1"><span class="font-medium">Event:</span> {{ $eventName }}</p>
                                                        @endif
                                                        
                                                        @if(!empty($eventDate))
                                                            <p class="mb-1"><span class="font-medium">Tanggal:</span> {{ $eventDate }}</p>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <a href="{{ route('ticket.view', $ticket->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700">
                                                            Lihat Tiket
                                                        </a>
                                                        @php
                                                            $hasTicketsShow = Route::has('tickets.show');
                                                        @endphp
                                                        @if($hasTicketsShow)
                                                            <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center ml-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                                                Tiket Alternatif
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-6 text-center">
                                <div class="space-x-4">
                                    <a href="{{ route('payment.history') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        Lihat Semua Pembayaran
                                    </a>
                                    <a href="{{ route('ticket.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Lihat Semua Tiket
                                    </a>
                                    @php
                                        $hasTicketsIndex = Route::has('tickets.index');
                                    @endphp
                                    @if($hasTicketsIndex)
                                        <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            Lihat Legacy Tiket
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-6 text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-4">
                                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-base font-medium text-gray-900 mb-1">Belum Ada Riwayat Pembayaran & Tiket</h4>
                                <p class="text-sm text-gray-500 mb-4">Anda belum memiliki pembayaran atau tiket untuk ditampilkan.</p>
                                <a href="{{ route('events') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700">
                                    Jelajahi Konser
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Direct Access Links -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-sm text-gray-600 mb-4 md:mb-0">
                            Ingin melihat acara atau konser terbaru? Kunjungi halaman events kami.
                        </p>
                        <div class="flex space-x-4">
                            <a href="{{ route('events') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                                Lihat Events
                            </a>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 