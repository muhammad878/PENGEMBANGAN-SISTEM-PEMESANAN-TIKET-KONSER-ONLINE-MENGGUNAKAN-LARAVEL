@extends('frontend.layouts.app')

@section('title', 'Detail Tiket - KonserKUY')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Back button -->
            <div class="mb-6">
                <a href="{{ route('payment.history') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-pink-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Riwayat Tiket
                </a>
            </div>

            <!-- Debug Info -->
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Debug Info:</strong>
                <p>Ticket ID: {{ $ticket->id ?? 'N/A' }}</p>
                <p>Ticket Code: {{ $ticket->code ?? 'N/A' }}</p>
                <p>Status: {{ $ticket->status ?? 'N/A' }}</p>
                <p>Is Used: {{ isset($ticket->is_used) ? ($ticket->is_used ? 'Yes' : 'No') : 'N/A' }}</p>
                <p>Created At: {{ isset($ticket->created_at) ? $ticket->created_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
            </div>

            <!-- Ticket Card -->
            @if(isset($ticket))
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Ticket Header -->
                <div class="bg-gradient-to-r from-pink-600 to-purple-600 p-6 text-white">
                    <h1 class="text-2xl font-bold">E-Ticket #{{ $ticket->code ?? 'Unknown' }}</h1>
                    <p class="text-pink-100 mt-1">
                        @if(isset($ticket->created_at))
                            Dibeli pada {{ $ticket->created_at->format('d M Y, H:i') }}
                        @else
                            Waktu pembelian tidak tersedia
                        @endif
                    </p>
                </div>

                <!-- Event Info -->
                <div class="p-6 border-b border-gray-200">
                    @php
                        $event = null;
                        if ($ticket->order && $ticket->order->event) {
                            $event = $ticket->order->event;
                        } elseif ($ticket->order && $ticket->order->items && $ticket->order->items->first() && $ticket->order->items->first()->event) {
                            $event = $ticket->order->items->first()->event;
                        } elseif ($ticket->orderItem && $ticket->orderItem->event) {
                            $event = $ticket->orderItem->event;
                        }
                    @endphp
                    
                    @if($event)
                        <div class="flex flex-col md:flex-row gap-4">
                            @if($event->image)
                                <div class="md:w-1/3">
                                    <div class="rounded-lg overflow-hidden">
                                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                                    </div>
                                </div>
                            @endif
                            <div class="md:w-2/3">
                                <h2 class="text-xl font-bold text-gray-800">{{ $event->title }}</h2>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-700">Tanggal & Waktu</div>
                                            <div class="text-gray-600">
                                                @if($ticket->event_date)
                                                    {{ \Carbon\Carbon::parse($ticket->event_date)->format('d F Y') }}
                                                @elseif($event->date)
                                                    {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}
                                                @else
                                                    TBA
                                                @endif
                                            
                                                @if($ticket->event_date)
                                                    {{ \Carbon\Carbon::parse($ticket->event_date)->format('H:i') }}
                                                @elseif($event->time)
                                                    {{ $event->time }}
                                                @elseif($event->date)
                                                    {{ \Carbon\Carbon::parse($event->date)->format('H:i') }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-700">Lokasi</div>
                                            <div class="text-gray-600">{{ $event->location }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                        <div>
                                            <div class="text-sm font-medium text-gray-700">Penyelenggara</div>
                                            <div class="text-gray-600">{{ $event->user ? $event->user->name : 'Unknown Organizer' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-gray-600 italic">Informasi event tidak tersedia</div>
                    @endif
                </div>

                <!-- Ticket Details -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Detail Tiket</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-1">Status Tiket</div>
                            <div>
                                @if(isset($ticket->status) && $ticket->status == 'active' && (!isset($ticket->is_used) || !$ticket->is_used))
                                    <span class="px-2.5 py-0.5 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        Aktif
                                    </span>
                                @elseif((isset($ticket->status) && $ticket->status == 'used') || (isset($ticket->is_used) && $ticket->is_used))
                                    <span class="px-2.5 py-0.5 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                        Digunakan
                                    </span>
                                @elseif(isset($ticket->status) && $ticket->status == 'expired')
                                    <span class="px-2.5 py-0.5 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                        Kadaluwarsa
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                        {{ $ticket->status ?? 'Status tidak diketahui' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-1">Kode Tiket</div>
                            <div class="font-medium">{{ $ticket->code ?? 'Tidak tersedia' }}</div>
                        </div>
                        
                        @if($ticket->used_at)
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-1">Digunakan Pada</div>
                            <div>{{ \Carbon\Carbon::parse($ticket->used_at)->format('d M Y, H:i') }}</div>
                        </div>
                        @endif
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500 mb-1">Pembelian</div>
                            <div>
                                @if($ticket->order)
                                    Order #{{ $ticket->order->order_number }}
                                @elseif($ticket->orderItem && $ticket->orderItem->order)
                                    Order #{{ $ticket->orderItem->order->order_number }}
                                @else
                                    Tidak diketahui
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- QR Code -->
                <div class="p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">QR Code Tiket</h3>
                    <div class="inline-block bg-white p-4 border border-gray-200 rounded-lg">
                        <div class="w-48 h-48 flex items-center justify-center mx-auto">
                            @if(isset($ticket->code))
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($ticket->code) }}" 
                                    alt="Ticket QR Code" class="w-44 h-44 mx-auto">
                            @else
                                <div class="w-44 h-44 flex items-center justify-center bg-gray-200 text-gray-500">
                                    QR Code tidak tersedia
                                </div>
                            @endif
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-4">Tunjukkan QR code ini kepada petugas saat memasuki venue</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="bg-gray-50 p-6 flex justify-center space-x-3">
                    <a href="{{ route('payment.history') }}" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                        Kembali ke Daftar Tiket
                    </a>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-8 text-center">
                <div class="bg-red-100 rounded-full p-4 inline-flex mb-4">
                    <svg class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">Tiket Tidak Ditemukan</h3>
                <p class="mb-4 text-gray-600">Tiket yang Anda cari tidak ditemukan atau sudah tidak tersedia.</p>
                <a href="{{ route('payment.history') }}" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    Kembali ke Daftar Tiket
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
