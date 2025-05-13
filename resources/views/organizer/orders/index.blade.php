@extends('layouts.organizer')

@php
    use Illuminate\Support\Str;
@endphp

@section('header')
    Manajemen Order
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Manajemen Penjualan Tiket</h1>
                <p class="mt-1 text-sm text-gray-500">Lihat dan kelola semua penjualan tiket Anda</p>
            </div>
            <a href="{{ route('organizer.orders.export') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export Data
            </a>
        </div>
        
        <div class="mb-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
                    <div class="bg-gray-50 p-4 rounded-md">
                        <span class="block text-gray-500 text-sm mb-1">Total Penjualan</span>
                        <span class="text-xl font-bold text-gray-900">Rp{{ number_format($orders->sum('total_amount'), 0, ',', '.') }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <span class="block text-gray-500 text-sm mb-1">Total Order</span>
                        <span class="text-xl font-bold text-gray-900">{{ $orders->total() }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <span class="block text-gray-500 text-sm mb-1">Pembayaran Berhasil</span>
                        <span class="text-xl font-bold text-green-500">{{ $orders->where('payment_status', 'paid')->count() }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <span class="block text-gray-500 text-sm mb-1">Pembayaran Pending</span>
                        <span class="text-xl font-bold text-amber-500">{{ $orders->where('payment_status', 'pending')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Daftar Order -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Daftar Order</h2>
                
                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembeli</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->user->email ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($order->event)
                                                {{ Str::limit($order->event->name, 25) }}
                                            @else
                                                Multiple Events
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($order->payment_status === 'paid')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lunas</span>
                                            @elseif($order->payment_status === 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($order->payment_status === 'failed')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Gagal</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $order->payment_status }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->payment_method ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button type="button" onclick="showOrderDetail('{{ $order->id }}')" class="text-indigo-600 hover:text-indigo-900">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada order</h3>
                        <p class="mt-1 text-sm text-gray-500">Ketika pengguna membeli tiket, order akan muncul di sini.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Modal Detail Order -->
        <div class="hidden fixed z-10 inset-0 overflow-y-auto" id="orderDetailModal">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Detail Order
                                </h3>
                                <div class="mt-4" id="orderDetails">
                                    <div class="flex justify-center items-center py-8">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="closeOrderDetail()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function showOrderDetail(orderId) {
            // Show modal
            document.getElementById('orderDetailModal').classList.remove('hidden');
            document.getElementById('orderDetails').innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Loading...</span>
                </div>
            `;
            
            // Fetch order details
            fetch(`/organizer/orders/${orderId}/detail`)
                .then(response => response.json())
                .then(data => {
                    let ticketsHtml = '';
                    
                    data.tickets.forEach(ticket => {
                        ticketsHtml += `
                            <tr>
                                <td class="px-4 py-2 text-sm">${ticket.name}</td>
                                <td class="px-4 py-2 text-sm text-center">${ticket.type}</td>
                                <td class="px-4 py-2 text-sm text-center">${ticket.pivot.quantity}</td>
                                <td class="px-4 py-2 text-sm text-right">Rp${parseFloat(ticket.price).toLocaleString('id-ID')}</td>
                                <td class="px-4 py-2 text-sm text-right">Rp${parseFloat(ticket.pivot.subtotal).toLocaleString('id-ID')}</td>
                            </tr>
                        `;
                    });
                    
                    let paymentStatus = '';
                    if (data.order.payment_status === 'paid') {
                        paymentStatus = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lunas</span>';
                    } else if (data.order.payment_status === 'pending') {
                        paymentStatus = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>';
                    } else {
                        paymentStatus = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Gagal</span>';
                    }
                    
                    document.getElementById('orderDetails').innerHTML = `
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Event</h4>
                                    <p class="text-sm font-medium">${data.event.name}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Order ID</h4>
                                    <p class="text-sm font-medium">${data.order.order_number}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Tanggal Order</h4>
                                    <p class="text-sm font-medium">${new Date(data.order.created_at).toLocaleString('id-ID')}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Status Pembayaran</h4>
                                    <p class="text-sm font-medium">${paymentStatus}</p>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Informasi Pembeli</h4>
                                <p class="text-sm font-medium">${data.buyer.name}</p>
                                <p class="text-sm text-gray-500">${data.buyer.email}</p>
                                <p class="text-sm text-gray-500">${data.buyer.phone || 'No Phone'}</p>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Detail Tiket</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tiket</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            ${ticketsHtml}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="px-4 py-2 text-right font-medium">Total:</td>
                                                <td class="px-4 py-2 text-right font-bold">Rp${parseFloat(data.order.total_amount).toLocaleString('id-ID')}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Informasi Pembayaran</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Metode Pembayaran</p>
                                        <p class="text-sm">${data.order.payment_method || 'N/A'}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Status</p>
                                        <p class="text-sm">${paymentStatus}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    document.getElementById('orderDetails').innerHTML = `
                        <div class="text-center py-4">
                            <p class="text-red-500">Error: Failed to load order details.</p>
                        </div>
                    `;
                    console.error('Error fetching order details:', error);
                });
        }
        
        function closeOrderDetail() {
            document.getElementById('orderDetailModal').classList.add('hidden');
        }
    </script>
@endsection 