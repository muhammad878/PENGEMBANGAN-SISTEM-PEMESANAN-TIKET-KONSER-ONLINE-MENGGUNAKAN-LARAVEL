<x-guest-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">Checkout</h1>
                <p class="mt-2 text-gray-600">Lengkapi informasi pembayaran untuk menyelesaikan pesanan Anda.</p>
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
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-xl font-semibold mb-4">Detail Pesanan</h2>

                            <div class="overflow-x-auto mb-4">
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
                                        @foreach($cartItems as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item['ticket']->event->title }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $item['ticket']->name }} ({{ $item['ticket']->type }})
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $item['ticket']->event->date->format('d M Y, H:i') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($item['ticket']->price, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $item['quantity'] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <form action="{{ route('checkout.process') }}" method="post">
                                @csrf
                                
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Metode Pembayaran</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center">
                                            <input id="bank_transfer" name="payment_method" type="radio" value="bank_transfer" class="focus:ring-pink-500 h-4 w-4 text-pink-600 border-gray-300" checked>
                                            <label for="bank_transfer" class="ml-3 block text-sm font-medium text-gray-700">
                                                Transfer Bank
                                                <p class="text-gray-500 text-xs mt-1">Bayar melalui transfer bank pilihan Anda.</p>
                                            </label>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <input id="e_wallet" name="payment_method" type="radio" value="e_wallet" class="focus:ring-pink-500 h-4 w-4 text-pink-600 border-gray-300">
                                            <label for="e_wallet" class="ml-3 block text-sm font-medium text-gray-700">
                                                E-Wallet
                                                <p class="text-gray-500 text-xs mt-1">Bayar melalui OVO, GoPay, DANA, atau LinkAja.</p>
                                            </label>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <input id="credit_card" name="payment_method" type="radio" value="credit_card" class="focus:ring-pink-500 h-4 w-4 text-pink-600 border-gray-300">
                                            <label for="credit_card" class="ml-3 block text-sm font-medium text-gray-700">
                                                Kartu Kredit
                                                <p class="text-gray-500 text-xs mt-1">Bayar dengan kartu Visa, Mastercard, atau JCB.</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Pesanan (Opsional)</label>
                                    <textarea id="notes" name="notes" rows="3" class="shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Tambahkan catatan khusus untuk pesanan Anda"></textarea>
                                </div>

                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pembeli</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                                            <div class="text-sm text-gray-900 bg-gray-100 p-2 rounded">
                                                {{ Auth::user()->name }}
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                            <div class="text-sm text-gray-900 bg-gray-100 p-2 rounded">
                                                {{ Auth::user()->email }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p class="text-xs text-gray-500 mt-2">
                                        Informasi pembeli diambil dari data akun Anda.
                                    </p>
                                </div>
                                
                                <div class="mb-6">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="terms" name="terms" type="checkbox" required class="focus:ring-pink-500 h-4 w-4 text-pink-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="terms" class="font-medium text-gray-700">Saya setuju dengan syarat dan ketentuan</label>
                                            <p class="text-gray-500">Dengan menekan tombol "Selesaikan Pembayaran", saya menyetujui <a href="{{ route('terms') }}" class="text-pink-600 hover:text-pink-500">Syarat dan Ketentuan</a> serta <a href="{{ route('privacy') }}" class="text-pink-600 hover:text-pink-500">Kebijakan Privasi</a> yang berlaku.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('cart.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                        Kembali ke Keranjang
                                    </a>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                        Selesaikan Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-xl font-semibold mb-4">Ringkasan Pembayaran</h2>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <dl class="divide-y divide-gray-200">
                                    <div class="py-2 flex justify-between">
                                        <dt class="text-sm text-gray-600">Subtotal</dt>
                                        <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                                    </div>
                                    <div class="py-2 flex justify-between">
                                        <dt class="text-sm text-gray-600">Biaya layanan</dt>
                                        <dd class="text-sm font-medium text-gray-900">Rp 0</dd>
                                    </div>
                                    <div class="py-2 flex justify-between">
                                        <dt class="text-sm text-gray-600">Pajak</dt>
                                        <dd class="text-sm font-medium text-gray-900">Termasuk</dd>
                                    </div>
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-base font-bold text-gray-900">Total</dt>
                                        <dd class="text-base font-bold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="mt-6">
                                <div class="rounded-md bg-gray-50 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1 md:flex md:justify-between">
                                            <p class="text-sm text-gray-700">
                                                E-ticket akan dikirim ke email Anda setelah pembayaran berhasil.
                                            </p>
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