@extends('frontend.layouts.app')

@section('title', 'Checkout Berhasil - KonserKUY')

@section('content')
<!-- Info debug (ditampilkan saat masalah terjadi) -->
@if(isset($showDebug) && $showDebug)
<div class="bg-red-100 text-red-900 p-4 text-sm mb-4">
    <h2 class="font-bold mb-2">INFORMASI DEBUG</h2>
    
    <div class="mb-4 p-2 border border-red-300">
        <h3 class="font-bold">Data Event yang Digunakan:</h3>
        <div class="pl-4">
            <p>ID: {{ isset($event) && isset($event->id) ? $event->id : 'Tidak ada' }}</p>
            <p>Judul: {{ isset($event) && isset($event->title) ? $event->title : 'Tidak ada' }}</p>
            <p>Tanggal: {{ isset($event) && isset($event->date) ? (is_string($event->date) ? $event->date : $event->date->format('d/m/Y')) : 'Tidak ada' }}</p>
            <p>Lokasi: {{ isset($event) && isset($event->location) ? $event->location : 'Tidak ada' }}</p>
        </div>
    </div>
    
    <div class="mb-2">
        <p>Menggunakan Event Dummy: {{ isset($event) && isset($dummyEvent) && $event === $dummyEvent ? 'Ya' : 'Tidak' }}</p>
    </div>
</div>
@endif

<div class="bg-slate-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="text-center p-8 bg-gradient-primary text-white">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold mb-2">Checkout Berhasil!</h1>
                <p class="text-lg">Terima kasih atas pembelian Anda</p>
            </div>
            
            <div class="p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Pemesanan</h2>
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-gray-600"><span class="font-medium text-gray-800">Nomor Pesanan:</span> #{{ session('checkout_order_number') ?? rand(100000, 999999) }}</p>
                        <span class="px-4 py-1 rounded-full text-white font-medium {{ session('checkout_payment_status') == 'LUNAS' ? 'bg-green-500' : 'bg-orange-500' }}">
                            {{ session('checkout_payment_status') ?? 'LUNAS' }}
                        </span>
                    </div>
                    <p class="text-gray-600 mb-2"><span class="font-medium text-gray-800">Tanggal Pembelian:</span> {{ session('checkout_date') ?? now()->format('d F Y, H:i') }}</p>
                    <p class="text-gray-600 mb-2"><span class="font-medium text-gray-800">Metode Pembayaran:</span> Kartu Kredit</p>
                </div>
                
                <div class="border rounded-lg overflow-hidden mb-6">
                    <div class="bg-gray-50 p-4 border-b">
                        <h3 class="font-bold text-gray-800">Informasi Tiket</h3>
                    </div>
                    <div class="p-4 space-y-6">
                        @if(session('checkout_items') && count(session('checkout_items')) > 0)
                            @foreach(session('checkout_items') as $item)
                                <div class="pb-4 {{ !$loop->last ? 'border-b border-gray-200 mb-4' : '' }}">
                                    @php
                                        try {
                                            // Ekstrak data dengan aman dengan nilai default
                                            $ticketId = isset($item['ticket']) && isset($item['ticket']->id) ? $item['ticket']->id : rand(1000, 9999);
                                            $eventId = isset($item['event']) && isset($item['event']->id) ? $item['event']->id : rand(1000, 9999);
                                            $eventTitle = isset($item['event']) && isset($item['event']->title) ? $item['event']->title : (isset($event) && isset($event->title) ? $event->title : 'Konser KUY');
                                            $eventLocation = isset($item['event']) && isset($item['event']->location) ? $item['event']->location : (isset($event) && isset($event->location) ? $event->location : 'Lokasi Konser');
                                            $ticketName = isset($item['ticket_name']) ? $item['ticket_name'] : (isset($item['ticket']) && isset($item['ticket']->name) ? $item['ticket']->name : 'Tiket');
                                            $ticketType = isset($item['ticket_type']) ? $item['ticket_type'] : '';
                                            
                                            // Logika untuk tanggal event
                                            $eventDate = 'Tanggal Konser';
                                            if (isset($item['event']) && isset($item['event']->date)) {
                                                if (is_string($item['event']->date)) {
                                                    $eventDate = $item['event']->date;
                                                } else if ($item['event']->date instanceof \DateTime || $item['event']->date instanceof \Carbon\Carbon) {
                                                    $eventDate = $item['event']->date->format('d F Y - H:i');
                                                }
                                            } else if (isset($event) && isset($event->date)) {
                                                if (is_string($event->date)) {
                                                    $eventDate = $event->date;
                                                } else if ($event->date instanceof \DateTime || $event->date instanceof \Carbon\Carbon) {
                                                    $eventDate = $event->date->format('d F Y - H:i');
                                                }
                                            }
                                            
                                            $ticketCode = isset($item['ticket_code']) 
                                                ? $item['ticket_code'] 
                                                : strtoupper(substr(md5($ticketId . $eventId . time() . rand(1000, 9999) . $loop->index), 0, 10));
                                            
                                            $qrData = json_encode([
                                                'event_id' => $eventId,
                                                'ticket_id' => $ticketId,
                                                'event_title' => $eventTitle,
                                                'ticket_name' => $ticketName,
                                                'ticket_type' => $ticketType,
                                                'code' => $ticketCode,
                                                'valid' => true
                                            ]);
                                            
                                            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=" . urlencode($qrData);
                                        } catch (\Exception $e) {
                                            $ticketCode = 'TKT-' . rand(1000, 9999);
                                            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=error";
                                            $eventTitle = 'Konser KUY';
                                            $eventLocation = 'Lokasi Konser';
                                            $eventDate = 'Tanggal Konser';
                                            $ticketName = 'Tiket';
                                        }
                                    @endphp

                                    <!-- Informasi Event & Tiket -->
                                    <div class="mb-4">
                                        <p class="text-gray-800 font-bold text-lg mb-1">{{ $eventTitle }}</p>
                                        <p class="text-gray-600 text-sm mb-1">{{ $eventLocation }}</p>
                                        <p class="text-gray-600 text-sm mb-2">{{ $eventDate }} WIB</p>
                                    </div>
                                    
                                    <!-- Ticket QR Code -->
                                    <div class="flex justify-between items-start py-3 px-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $ticketName }}</p>
                                            <p class="text-sm text-gray-600 mt-1">Jumlah: {{ $item['quantity'] ?? 1 }}</p>
                                            <p class="text-primary-600 font-mono mt-2">{{ $ticketCode }}</p>
                                            <p class="text-sm text-gray-500 mt-1">Tunjukkan kode ini saat masuk venue</p>
                                        </div>
                                        
                                        <div class="bg-white p-2 rounded shadow-sm">
                                            <img src="{{ $qrUrl }}" 
                                                alt="QR Code" class="w-24 h-24">
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between items-center mt-3">
                                        <div>
                                            <p class="text-sm text-gray-500">Harga: Rp {{ isset($item['ticket']) && isset($item['ticket']->price) ? number_format($item['ticket']->price, 0, ',', '.') : (isset($item['price']) ? number_format($item['price'], 0, ',', '.') : '0') }}</p>
                                        </div>
                                        <p class="font-bold text-gradient">Rp {{ isset($item['subtotal']) ? number_format($item['subtotal'], 0, ',', '.') : '0' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        
                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between text-gray-700">
                                    <p>Subtotal</p>
                                    <p>Rp {{ number_format(session('checkout_subtotal') ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <p>Pajak (11%)</p>
                                    <p>Rp {{ number_format(session('checkout_tax') ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <p>Biaya Layanan</p>
                                    <p>Rp {{ number_format(session('checkout_service_fee') ?? 50000, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between font-bold pt-2 border-t">
                                    <p>Total</p>
                                    <p class="text-gradient">Rp {{ number_format(session('checkout_total') ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @else
                            <!-- Data Tiket Fallback -->
                            @php
                                $fallbackEvent = isset($event) ? $event : (isset($dummyEvent) ? $dummyEvent : (object)[
                                    'id' => 1,
                                    'title' => 'Konser KUY Festival',
                                    'date' => now(),
                                    'location' => 'Jakarta Convention Center'
                                ]);
                                
                                $fallbackTitle = $fallbackEvent->title ?? 'Konser KUY Festival';
                                $fallbackLocation = $fallbackEvent->location ?? 'Jakarta Convention Center';
                                
                                $fallbackDate = 'Tanggal Konser';
                                if (isset($fallbackEvent->date)) {
                                    if ($fallbackEvent->date instanceof \DateTime || $fallbackEvent->date instanceof \Carbon\Carbon) {
                                        $fallbackDate = $fallbackEvent->date->format('d F Y - H:i');
                                    } elseif (is_string($fallbackEvent->date)) {
                                        $fallbackDate = $fallbackEvent->date;
                                    }
                                }
                                
                                // Generate ticket data
                                $ticketCode = 'KUY' . strtoupper(substr(md5(time() . rand(1000, 9999)), 0, 10));
                                $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=" . urlencode($ticketCode);
                            @endphp
                            
                            <!-- Informasi Konser -->
                            <div class="mb-4">
                                <p class="text-gray-800 font-bold text-lg mb-1">{{ $fallbackTitle }}</p>
                                <p class="text-gray-600 text-sm mb-2">{{ $fallbackLocation }}</p>
                                <p class="text-gray-600 text-sm mb-4">{{ $fallbackDate }} WIB</p>
                            </div>
                            
                            <!-- Tiket QR Code -->
                            <div class="flex justify-between items-start py-3 px-4 bg-gray-50 rounded-lg mb-4">
                                <div>
                                    <p class="font-medium text-gray-800">Tiket Regular</p>
                                    <p class="text-sm text-gray-600 mt-1">Jumlah: 1</p>
                                    <p class="text-primary-600 font-mono mt-2">{{ $ticketCode }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Tunjukkan kode ini saat masuk venue</p>
                                </div>
                                
                                <div class="bg-white p-2 rounded shadow-sm">
                                    <img src="{{ $qrUrl }}" 
                                        alt="QR Code" class="w-24 h-24">
                                </div>
                            </div>
                            
                            <!-- Total -->
                            <div class="border-t pt-4 mt-6 space-y-2">
                                <div class="flex justify-between text-gray-700">
                                    <p>Subtotal</p>
                                    <p>Rp {{ number_format(session('checkout_subtotal') ?? 500000, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <p>Pajak (11%)</p>
                                    <p>Rp {{ number_format(session('checkout_tax') ?? 55000, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <p>Biaya Layanan</p>
                                    <p>Rp {{ number_format(session('checkout_service_fee') ?? 50000, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between font-bold pt-2 border-t">
                                    <p>Total</p>
                                    <p class="text-gradient">Rp {{ number_format(session('checkout_total') ?? 605000, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8">
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mt-0.5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-700">E-tiket akan dikirimkan ke alamat email yang Anda daftarkan. Silakan tunjukkan tiket ini di pintu masuk pada hari acara.</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-center gap-4">
                    <a href="{{ route('home') }}" class="px-6 py-2 bg-gray-100 text-gray-800 rounded-full hover:bg-gray-200 transition-colors">Kembali ke Beranda</a>
                    @auth
                        <a href="{{ route('payment.history') }}" class="px-6 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-colors">Lihat Pesanan Saya</a>
                    @endauth
                    <a href="{{ route('events') }}" class="px-6 py-2 bg-gradient-primary text-white rounded-full hover:shadow-lg transition-all">Jelajahi Konser Lainnya</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 