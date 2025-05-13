<x-guest-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">Pembayaran</h1>
                <p class="mt-2 text-gray-600">Selesaikan pembayaran untuk melanjutkan pesanan Anda.</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-xl font-semibold mb-4">Instruksi Pembayaran</h2>
                            
                            <div class="mb-6">
                                <div class="text-lg font-medium mb-3">{{ $paymentInstructions['title'] }}</div>
                                
                                <div class="space-y-2 mb-4">
                                    @foreach($paymentInstructions['steps'] as $step)
                                        <div class="flex items-start">
                                            <span class="text-pink-500 mr-2">•</span>
                                            <p class="text-gray-700">{{ $step }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="bg-blue-50 p-4 rounded-md">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700">
                                                {{ $paymentInstructions['note'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium mb-4">Upload Bukti Pembayaran</h3>
                                
                                <form action="{{ route('payment.confirm', $order->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                                            Bukti Pembayaran
                                        </label>
                                        <input type="file" name="payment_proof" id="payment_proof" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100" required>
                                        @error('payment_proof')
                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-1">
                                            Unggah bukti pembayaran Anda dalam format JPG, JPEG, atau PNG (maks. 2MB).
                                        </p>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                            Konfirmasi Pembayaran
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-xl font-semibold mb-4">Detail Pesanan</h2>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tiket
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Harga
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Jumlah
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Subtotal
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->ticket->event->title }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $item->ticket->name }} ({{ $item->ticket->type }})
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Ringkasan Pesanan</h3>
                            
                            <div class="border-t border-gray-200 pt-4">
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
                                    <div class="py-2 flex justify-between">
                                        <dt class="text-base font-bold text-gray-900">Total</dt>
                                        <dd class="text-base font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="mt-6">
                                <div class="rounded-md bg-yellow-50 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-yellow-800">Penting!</h3>
                                            <div class="mt-2 text-sm text-yellow-700">
                                                <p>Harap selesaikan pembayaran dalam waktu 24 jam. Pesanan akan otomatis dibatalkan jika pembayaran tidak diterima.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout> 