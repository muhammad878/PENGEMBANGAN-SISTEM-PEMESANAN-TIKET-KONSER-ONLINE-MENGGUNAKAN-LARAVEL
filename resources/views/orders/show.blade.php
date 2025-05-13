<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <div class="p-2 bg-pink-600 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        {{ __('Detail Pesanan') }}
                    </h2>
                    <p class="text-gray-500 text-sm">Lihat detail pesanan #{{ $order->order_number }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-pink-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Profil Saya
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan</h1>
                <a href="{{ route('orders.index') }}" class="text-pink-600 hover:text-pink-700 font-medium">
                    &larr; Kembali ke Pesanan
                </a>
            </div>
            
            <!-- Order Info -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full sm:w-1/2 px-3 mb-4 sm:mb-0">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Informasi Pesanan</h2>
                            <div class="space-y-1">
                                <p class="text-gray-600"><span class="font-medium">No. Pesanan:</span> {{ $order->order_number }}</p>
                                <p class="text-gray-600"><span class="font-medium">Tanggal:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
                                <p class="text-gray-600"><span class="font-medium">Status Pesanan:</span> 
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full 
                                        @if($order->status == 'completed') bg-green-100 text-green-800 
                                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800 
                                        @else bg-gray-100 text-gray-800 
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="w-full sm:w-1/2 px-3">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Informasi Pembayaran</h2>
                            <div class="space-y-1">
                                <p class="text-gray-600"><span class="font-medium">Metode Pembayaran:</span> {{ ucfirst($order->payment_method) }}</p>
                                <p class="text-gray-600"><span class="font-medium">Status Pembayaran:</span> 
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full 
                                        @if($order->payment_status == 'paid') bg-green-100 text-green-800 
                                        @elseif($order->payment_status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($order->payment_status == 'failed') bg-red-100 text-red-800 
                                        @else bg-gray-100 text-gray-800 
                                        @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </p>
                                @if($order->transaction_id)
                                    <p class="text-gray-600"><span class="font-medium">ID Transaksi:</span> {{ $order->transaction_id }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Item Tiket</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Konser
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis Tiket
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subtotal
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $item->ticket->event->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $item->ticket->event->date->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $item->ticket->event->venue }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $item->ticket->name }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $item->quantity }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-right text-sm font-medium text-gray-500">
                                    Total
                                </td>
                                <td class="px-4 py-3 text-sm font-bold text-gray-900">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    @if($order->status === 'completed')
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 active:bg-pink-900 focus:outline-none focus:border-pink-900 focus:ring focus:ring-pink-300 disabled:opacity-25 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh E-Ticket
                        </a>
                    @elseif($order->status === 'pending' && $order->payment_status === 'pending')
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Lanjutkan Pembayaran
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 