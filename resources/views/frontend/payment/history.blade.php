@extends('frontend.layouts.app')

@section('title', 'Riwayat Pembayaran & Tiket - KonserKUY')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gradient mb-2">Riwayat Pembayaran & Tiket</h1>
                <p class="text-gray-600">Pantau pesanan Anda dan akses semua tiket konser yang telah Anda beli</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @endif

            <!-- Ticket Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Total Tiket</div>
                            <div class="text-xl font-bold">{{ $ticketsCount ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-lg p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Tiket Aktif</div>
                            <div class="text-xl font-bold">{{ $activeTicketsCount ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="bg-red-100 rounded-lg p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Tiket Terpakai</div>
                            <div class="text-xl font-bold">{{ $usedTicketsCount ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="bg-gray-100 rounded-lg p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Tiket Kadaluarsa</div>
                            <div class="text-xl font-bold">{{ $expiredTicketsCount ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">Daftar Pesanan & Tiket</h2>
                </div>
                
                @if(isset($orders) && $orders->isNotEmpty())
                    <!-- Display orders with payments -->
                    @foreach($orders as $order)
                    <div class="border-b border-gray-100 hover:bg-gray-50">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row justify-between mb-4">
                                <div>
                                    <div class="text-xl font-semibold text-gray-800 mb-1">
                                        Pembelian #{{ $order->order_number }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                                <div class="mt-2 md:mt-0">
                                    @if($order->payment_status == 'pending')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Menunggu Pembayaran
                                        </span>
                                    @elseif($order->payment_status == 'processing')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Sedang Diproses
                                        </span>
                                    @elseif($order->payment_status == 'paid')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Sukses
                                        </span>
                                    @elseif($order->payment_status == 'failed')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Gagal
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $order->payment_status }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="text-sm font-medium text-gray-500 mb-1">Detail Pembayaran:</div>
                                <div class="flex flex-wrap gap-4 text-sm">
                                    <div>
                                        <span class="font-medium">Metode:</span>
                                        @if($order->payment_method == 'bank_transfer')
                                            Transfer Bank
                                        @elseif($order->payment_method == 'e_wallet')
                                            E-Wallet
                                        @elseif($order->payment_method == 'credit_card')
                                            Kartu Kredit
                                        @else
                                            {{ $order->payment_method ?? 'Tidak Tersedia' }}
                                        @endif
                                    </div>
                                    <div>
                                        <span class="font-medium">Total:</span>
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </div>
                                    @if(isset($order->payment) && isset($order->payment->proof_of_payment))
                                    <div>
                                        <a href="{{ $order->payment->proof_of_payment }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                            Lihat Bukti Pembayaran
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Tiket -->
                            <div class="mb-4">
                                <div class="text-sm font-medium text-gray-500 mb-2">Tiket yang Dibeli:</div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if(isset($order->eTickets) && $order->eTickets->isNotEmpty())
                                        @foreach($order->eTickets as $eTicket)
                                            <div class="border rounded-lg p-3 bg-gray-50">
                                                <div class="font-medium">E-Ticket #{{ $eTicket->code }}</div>
                                                <div class="text-sm text-gray-600">
                                                    @if($eTicket->event_date)
                                                    <span>Tanggal Event:</span> {{ \Carbon\Carbon::parse($eTicket->event_date)->format('d M Y, H:i') }}
                                                    @endif
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    <span>Status:</span>
                                                    @if($eTicket->status == 'active' || $eTicket->is_used == 0)
                                                        <span class="text-green-600">Aktif</span>
                                                    @elseif($eTicket->status == 'used' || $eTicket->is_used == 1)
                                                        <span class="text-red-600">Terpakai</span>
                                                    @else
                                                        <span class="text-gray-600">{{ $eTicket->status }}</span>
                                                    @endif
                                                </div>
                                                <div class="mt-2">
                                                    <a href="{{ route('payment.ticket', $eTicket->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                        Lihat Tiket
                                                    </a>
                                                    <!-- Debug information -->
                                                    <div class="mt-1 text-xs text-gray-500">
                                                        Ticket ID: {{ $eTicket->id }}
                                                    </div>
                                                    <!-- Debug Link -->
                                                    <a href="{{ route('debug.ticket', $eTicket->id) }}" class="text-red-600 hover:text-red-900 text-xs font-medium mt-1 block">
                                                        Debug Ticket
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @elseif(isset($order->items) && $order->items->isNotEmpty())
                                        @foreach($order->items as $item)
                                            <div class="border rounded-lg p-3 bg-gray-50">
                                                <div class="font-medium">
                                                    {{ $item->ticket->name ?? 'Unknown Ticket' }} 
                                                    @if(isset($item->event))
                                                    ({{ $item->event->title ?? 'Unknown Event' }})
                                                    @elseif(isset($item->ticket) && isset($item->ticket->event))
                                                    ({{ $item->ticket->event->title ?? 'Unknown Event' }})
                                                    @endif
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    <span>Jumlah:</span> {{ $item->quantity }}
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    <span>Harga:</span> Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    <span>Subtotal:</span> Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-span-2 text-gray-500 text-sm italic">
                                            Tidak ada data tiket tersedia
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                @else
                <div class="p-8 text-center text-gray-500">
                    <div class="bg-gray-100 rounded-full p-4 inline-flex mb-4">
                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Belum Ada Tiket</h3>
                    <p class="mb-4">Anda belum memiliki tiket atau riwayat pesanan. Mulailah dengan menjelajahi konser-konser menarik!</p>
                    <div class="mt-4">
                        <a href="{{ route('events') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382z" />
                            </svg>
                            Jelajahi Konser
                        </a>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Direct Links -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Tampilan Tiket Baru</h3>
                    <p class="text-gray-600 mb-4">Lihat tiket Anda dengan tampilan yang lebih modern dan responsif.</p>
                    <a href="{{ route('ticket.index') }}" class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        Lihat Tiket Baru
                    </a>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Tampilan Tiket Legacy</h3>
                    <p class="text-gray-600 mb-4">Akses tampilan tiket sebelumnya dengan fitur filter dan pencarian.</p>
                    <a href="{{ route('tickets.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Lihat Tiket Legacy
                    </a>
                </div>
            </div>
            
            <!-- Back to Dashboard -->
            <div class="text-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 