@extends('frontend.layouts.app')

@section('title', 'Pembayaran Berhasil - KonserKUY')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
            <div class="p-6 border-b border-gray-200">
                <div class="text-center mb-8">
                    <div class="mb-4">
                        <svg class="mx-auto h-16 w-16 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Pembayaran Dikonfirmasi!</h1>
                    <p class="mt-2 text-gray-600 max-w-2xl mx-auto">
                        Terima kasih, bukti pembayaran Anda telah diterima dan sedang dalam proses verifikasi. Anda akan menerima notifikasi saat pembayaran Anda telah diverifikasi.
                    </p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg mb-8">
                    <h2 class="text-xl font-semibold mb-4">Detail Pesanan</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dl class="divide-y divide-gray-200">
                                <div class="py-2 flex justify-between">
                                    <dt class="text-sm text-gray-600">Nomor Pesanan</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $order->order_number }}</dd>
                                </div>
                                <div class="py-2 flex justify-between">
                                    <dt class="text-sm text-gray-600">Tanggal Pesanan</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                                </div>
                                <div class="py-2 flex justify-between">
                                    <dt class="text-sm text-gray-600">Total Pembayaran</dt>
                                    <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
                                </div>
                                <div class="py-2 flex justify-between">
                                    <dt class="text-sm text-gray-600">Metode Pembayaran</dt>
                                    <dd class="text-sm font-medium text-gray-900">
                                        @if($order->payment_method == 'bank_transfer')
                                            Transfer Bank
                                        @elseif($order->payment_method == 'e_wallet')
                                            E-Wallet
                                        @elseif($order->payment_method == 'credit_card')
                                            Kartu Kredit
                                        @else
                                            {{ $order->payment_method }}
                                        @endif
                                    </dd>
                                </div>
                                <div class="py-2 flex justify-between">
                                    <dt class="text-sm text-gray-600">Status Pembayaran</dt>
                                    <dd class="text-sm font-medium">
                                        @if($order->payment_status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu Pembayaran
                                            </span>
                                        @elseif($order->payment_status == 'processing')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Sedang Diproses
                                            </span>
                                        @elseif($order->payment_status == 'paid')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Berhasil Dibayar
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $order->payment_status }}
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                @if(isset($order->payment) && $order->payment->proof_of_payment)
                                <div class="py-2 flex justify-between">
                                    <dt class="text-sm text-gray-600">Bukti Pembayaran</dt>
                                    <dd class="text-sm font-medium text-blue-600">
                                        <a href="{{ $order->payment->proof_of_payment }}" target="_blank" class="flex items-center hover:underline">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                            Lihat Bukti
                                        </a>
                                    </dd>
                                </div>
                                @endif
                                @if(isset($order->payment) && $order->payment->payment_code)
                                <div class="py-2 flex justify-between">
                                    <dt class="text-sm text-gray-600">Kode Pembayaran</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $order->payment->payment_code }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Event yang Dibeli</h3>
                            <ul class="space-y-3">
                                @foreach($order->items as $item)
                                    <li class="border-l-4 border-primary-600 pl-4 py-2">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $item->ticket->event->title }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $item->ticket->event->date->format('l, d M Y, H:i') }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $item->ticket->name }} - {{ $item->quantity }} tiket
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Apa selanjutnya?</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Sistem kami akan otomatis memverifikasi pembayaran Anda. E-tiket akan tersedia di halaman "Tiket Saya" segera setelah pembayaran diverifikasi. Anda juga akan menerima email konfirmasi dengan e-tiket.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 justify-center">
                    <a href="{{ route('payment.history') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Lihat Tiket Saya
                    </a>
                    <a href="{{ route('payment.history') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Riwayat Pembayaran
                    </a>
                    <a href="{{ route('events') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Jelajahi Konser Lainnya
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 