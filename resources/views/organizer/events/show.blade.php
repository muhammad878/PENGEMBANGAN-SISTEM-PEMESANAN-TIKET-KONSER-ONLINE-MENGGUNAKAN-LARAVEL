@extends('layouts.organizer')

@php
use Illuminate\Support\Facades\DB;
@endphp

@section('header')
    Detail Event
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $event->title }}</h1>
                <p class="mt-1 text-sm text-gray-500">Detail lengkap event dan statistik penjualan tiket</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('organizer.events.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
                @if($event->status != 'completed')
                    <a href="{{ route('organizer.events.edit', $event->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Event
                    </a>
                @endif
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Event Status -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">Status Event</h2>
                                <p class="mt-1 text-sm text-gray-500">Status persetujuan dan publikasi event</p>
                            </div>
                            <div>
                                {!! $event->status_badge !!}
                            </div>
                        </div>
                        
                        @if($event->status === 'pending')
                            <div class="mt-4 bg-yellow-50 p-4 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Event sedang menunggu persetujuan admin</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>Mohon tunggu hingga admin menyetujui event ini. Event yang telah disetujui akan muncul di halaman utama website.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($event->status === 'rejected')
                            <div class="mt-4 bg-red-50 p-4 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Event ditolak oleh admin</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>Alasan: {{ $event->rejection_reason ?: 'Tidak ada alasan yang diberikan.' }}</p>
                                            <p class="mt-1">Silakan edit event sesuai dengan alasan penolakan dan submit ulang untuk ditinjau kembali.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($event->status === 'active')
                            <div class="mt-4 bg-green-50 p-4 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">Event aktif dan siap dijual</h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>Event Anda telah disetujui dan tersedia untuk umum. Pengguna dapat melihat dan membeli tiket event ini.</p>
                                            <p class="mt-1">
                                                <a href="{{ route('organizer.tickets.index', $event->id) }}" class="font-medium text-green-600 hover:text-green-500">
                                                    Kelola tiket event →
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Event Details -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Event</h2>
                        
                        @if($event->poster_path)
                            <div class="mb-6">
                                <img src="{{ asset($event->poster_path) }}" alt="{{ $event->title }}" class="rounded-lg max-h-80 mx-auto">
                            </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Nama Event</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $event->title }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Kategori</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $event->category }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Lokasi</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $event->location }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Tanggal Event</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $event->event_date ? $event->event_date->format('d M Y - H:i') : 'N/A' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Harga Tiket Dasar</h3>
                                <p class="mt-1 text-sm text-gray-900">Rp{{ number_format($event->ticket_price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Kuota Tiket</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $event->ticket_quantity }} tiket</p>
                            </div>
                        </div>
                        
                        <!-- Foto Venue -->
                        @if($event->venue_image_path)
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Foto Venue/Lokasi</h3>
                                <img src="{{ asset($event->venue_image_path) }}" alt="Venue {{ $event->title }}" class="rounded-lg w-full h-auto">
                            </div>
                        @endif
                        
                        <!-- Google Maps -->
                        @if($event->maps_link)
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Lokasi di Google Maps</h3>
                                <div class="maps-container rounded-lg overflow-hidden">
                                    <style>
                                        .maps-container iframe {
                                            width: 100%;
                                            height: 400px;
                                            border: 0;
                                        }
                                    </style>
                                    {!! $event->maps_link !!}
                                </div>
                            </div>
                        @endif
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Deskripsi Event</h3>
                            <div class="mt-2 text-sm text-gray-900 prose max-w-none">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Ticket Info -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-900">Informasi Tiket</h2>
                            @if($event->status === 'active')
                                <a href="{{ route('organizer.tickets.index', $event->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                                    Kelola Tiket
                                </a>
                            @endif
                        </div>
                        
                        <div class="bg-gray-50 rounded-md p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Total Kuota</p>
                                    <p class="text-lg font-semibold">{{ $event->ticket_quantity }} tiket</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Harga Dasar</p>
                                    <p class="text-lg font-semibold">Rp{{ number_format($event->ticket_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($event->status === 'active')
                            <p class="text-sm text-gray-500 mb-2">Kategori Tiket</p>
                            <div class="space-y-2">
                                @php
                                    $tickets = \App\Models\Ticket::where('event_id', $event->id)->get();
                                    $ticketsSold = 0;
                                    foreach ($tickets as $ticket) {
                                        $ticketsSold += ($ticket->quantity - $ticket->remaining);
                                    }
                                    
                                    // Calculate revenue using ticket_id which links to the event
                                    $revenue = \App\Models\Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
                                        ->join('tickets', 'order_items.ticket_id', '=', 'tickets.id')
                                        ->where('tickets.event_id', $event->id)
                                        ->where('orders.payment_status', 'paid')
                                        ->sum('orders.total_amount');
                                @endphp
                                
                                @if(count($tickets) > 0)
                                    @foreach($tickets as $ticket)
                                        <div class="flex justify-between p-2 border rounded-md">
                                            <div>
                                                <p class="font-medium">{{ $ticket->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $ticket->remaining }}/{{ $ticket->quantity }} tersisa</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-medium">Rp{{ number_format($ticket->price, 0, ',', '.') }}</p>
                                                <p class="text-xs text-gray-500">{{ $ticket->status }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center p-4 bg-gray-50 rounded-md">
                                        <p class="text-sm text-gray-500">Belum ada kategori tiket</p>
                                        <a href="{{ route('organizer.tickets.index', $event->id) }}" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                            Tambah kategori tiket sekarang
                                            <svg class="ml-1 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-md p-4 text-center">
                                <p class="text-sm text-gray-500">Manajemen tiket tersedia setelah event disetujui.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Sales Statistics -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Statistik Penjualan</h2>
                        
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-md p-3">
                                <p class="text-sm font-medium text-gray-500">Tiket Terjual</p>
                                <p class="text-xl font-bold">{{ $ticketsSold }} <span class="text-sm font-normal text-gray-500">dari {{ $event->ticket_quantity }}</span></p>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $event->ticket_quantity > 0 ? ($ticketsSold / $event->ticket_quantity) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-md p-3">
                                <p class="text-sm font-medium text-gray-500">Pendapatan</p>
                                <p class="text-xl font-bold">Rp{{ number_format($revenue, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Link Cepat</h2>
                        <div class="space-y-2">
                            @if($event->status === 'active')
                                <a href="{{ route('organizer.tickets.index', $event->id) }}" class="flex items-center p-2 -m-2 rounded-md hover:bg-gray-50">
                                    <svg class="flex-shrink-0 h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Manajemen Tiket</p>
                                        <p class="text-xs text-gray-500">Kelola kategori tiket</p>
                                    </div>
                                </a>
                            @endif
                            
                            <a href="{{ route('organizer.orders') }}" class="flex items-center p-2 -m-2 rounded-md hover:bg-gray-50">
                                <svg class="flex-shrink-0 h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Penjualan Tiket</p>
                                    <p class="text-xs text-gray-500">Lihat semua transaksi</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('organizer.events.edit', $event->id) }}" class="flex items-center p-2 -m-2 rounded-md hover:bg-gray-50">
                                <svg class="flex-shrink-0 h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Edit Event</p>
                                    <p class="text-xs text-gray-500">Update informasi event</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 