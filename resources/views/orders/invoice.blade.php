<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <div class="p-2 bg-pink-600 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        {{ __('Invoice Pesanan') }}
                    </h2>
                    <p class="text-gray-500 text-sm">Invoice No. #{{ $order->order_number }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-pink-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                    </svg>
                    Cetak
                </button>
                <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-200 transition">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12" id="invoice-print">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-8">
                <!-- Header -->
                <div class="border-b pb-8 mb-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="h-12 w-auto">
                                <img src="{{ asset('images/logo.png') }}" alt="KonserKUY Logo" class="h-full">
                            </div>
                            <h1 class="text-3xl font-bold text-gray-900 mt-4">INVOICE</h1>
                            <p class="text-gray-600">Invoice untuk pembelian tiket konser</p>
                        </div>
                        <div class="text-right">
                            <span class="px-4 py-1 rounded-full text-white font-medium {{ $order->payment_status === 'paid' ? 'bg-green-500' : 'bg-orange-500' }}">
                                {{ $order->payment_status === 'paid' ? 'LUNAS' : 'BELUM DIBAYAR' }}
                            </span>
                            <p class="text-gray-700 mt-2">No. Invoice: #{{ $order->order_number }}</p>
                            <p class="text-gray-700">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Customer & Company Information -->
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h2 class="text-gray-800 font-semibold mb-2">Informasi Pemesan:</h2>
                        <p class="text-gray-700">{{ $order->user->name }}</p>
                        <p class="text-gray-700">{{ $order->user->email }}</p>
                        <p class="text-gray-700">{{ $order->user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <h2 class="text-gray-800 font-semibold mb-2">Dari:</h2>
                        <p class="text-gray-700">KonserKUY.com</p>
                        <p class="text-gray-700">Jl. Musik Asyik No. 123</p>
                        <p class="text-gray-700">Jakarta, Indonesia</p>
                        <p class="text-gray-700">help@konserkuy.com</p>
                    </div>
                </div>
                
                <!-- Order Details -->
                <div class="mb-8">
                    <h2 class="text-gray-800 font-semibold mb-4">Detail Pesanan:</h2>
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Tiket
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php $subtotal = 0; @endphp
                                @foreach($order->items as $item)
                                    @php $subtotal += $item->subtotal; @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $item->event->title ?? $item->ticket->event->title ?? 'Event' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                @if(isset($item->event->date) || isset($item->ticket->event->date))
                                                    {{ 
                                                        isset($item->event->date) 
                                                        ? (is_string($item->event->date) ? $item->event->date : $item->event->date->format('d M Y')) 
                                                        : (is_string($item->ticket->event->date) ? $item->ticket->event->date : $item->ticket->event->date->format('d M Y')) 
                                                    }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $item->ticket->name ?? $item->ticket->ticket_type ?? 'Tiket' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-700">
                                        Subtotal
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @php 
                                    $tax = $subtotal * 0.11; 
                                    $serviceFee = 50000;
                                @endphp
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-700">
                                        Pajak (11%)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        Rp {{ number_format($tax, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-700">
                                        Biaya Layanan
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        Rp {{ number_format($serviceFee, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr class="bg-gray-100">
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-right text-base font-bold text-gray-900">
                                        Total
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-base font-bold text-gray-900">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <!-- Payment Info -->
                <div class="mb-8">
                    <h2 class="text-gray-800 font-semibold mb-4">Informasi Pembayaran:</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Metode Pembayaran:</p>
                                <p class="text-sm font-medium text-gray-800">{{ ucfirst($order->payment_method ?? 'Kartu Kredit') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Pembayaran:</p>
                                <p class="text-sm font-medium">
                                    <span class="px-2 py-1 rounded-full text-xs text-white font-medium {{ $order->payment_status === 'paid' ? 'bg-green-500' : 'bg-orange-500' }}">
                                        {{ $order->payment_status === 'paid' ? 'LUNAS' : 'BELUM DIBAYAR' }}
                                    </span>
                                </p>
                            </div>
                            @if($order->payment && $order->payment->paid_at)
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Pembayaran:</p>
                                <p class="text-sm font-medium text-gray-800">{{ $order->payment->paid_at->format('d M Y, H:i') }}</p>
                            </div>
                            @endif
                            @if($order->payment && $order->payment->payment_code)
                            <div>
                                <p class="text-sm text-gray-600">Kode Pembayaran:</p>
                                <p class="text-sm font-medium text-gray-800">{{ $order->payment->payment_code }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Notes & Terms -->
                <div class="border-t pt-8">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <h2 class="text-gray-800 font-semibold mb-2">Catatan:</h2>
                            <p class="text-sm text-gray-600">{{ $order->notes ?? 'Terima kasih telah membeli tiket di KonserKUY! Jangan lupa untuk membawa bukti pembelian (e-ticket) pada saat acara berlangsung.' }}</p>
                        </div>
                        <div>
                            <h2 class="text-gray-800 font-semibold mb-2">Syarat dan Ketentuan:</h2>
                            <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                                <li>Tiket yang sudah dibeli tidak dapat dikembalikan atau ditukar</li>
                                <li>Hadir tepat waktu sesuai jadwal konser</li>
                                <li>Tunjukkan e-ticket di pintu masuk venue</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #invoice-print, #invoice-print * {
                visibility: visible;
            }
            #invoice-print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</x-app-layout> 