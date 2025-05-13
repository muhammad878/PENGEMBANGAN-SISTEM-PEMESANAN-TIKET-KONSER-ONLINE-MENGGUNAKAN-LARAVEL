@extends('frontend.layouts.app')

@section('title', 'Checkout - KonserKUY')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gradient mb-2">Checkout</h1>
                <p class="text-gray-600">Selesaikan pembelian Anda untuk mendapatkan tiket konser</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('warning') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="post" id="checkout-form">
                @csrf
                <input type="hidden" name="event_id" value="{{ isset($primaryEvent) && $primaryEvent ? $primaryEvent->id : '' }}">
                <input type="hidden" name="total" id="final_total" value="{{ $total }}">
                <input type="hidden" name="payment_method" value="credit_card">

                <!-- Order Summary -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800">Ringkasan Pembelian</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Order Items -->
                            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                Konser & Jenis Tiket
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                Harga Satuan
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                Jumlah
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                Subtotal
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @php
                                            $calculatedSubtotal = 0;
                                            $eventSubtotals = [];
                                            $currentEventId = null;
                                        @endphp
                                        
                                        @foreach($cartItems as $item)
                                            @php
                                                $itemPrice = (float)($item['price'] ?? 0);
                                                $itemQuantity = (int)($item['quantity'] ?? 0);
                                                $itemSubtotal = $itemPrice * $itemQuantity;
                                                $calculatedSubtotal += $itemSubtotal;
                                                
                                                // Pastikan data tiket selalu tersedia
                                                $ticketName = $item['ticket_name'] ?? ($item['ticket']->name ?? 'Tiket');
                                                $ticketType = $item['ticket_type'] ?? ($item['ticket']->type ?? '');
                                                $eventData = $item['event'] ?? null;
                                                $eventTitle = $eventData ? ($eventData->title ?? 'Event') : 'Event';
                                            @endphp
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10 bg-primary-100 rounded-md flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                            </svg>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $eventTitle }}
                                                            </div>
                                                            <div class="text-sm text-gray-700 font-medium">{{ $ticketName }}</div>
                                                            <div class="text-xs text-gray-500">{{ $ticketType }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <div class="text-sm text-gray-900">Rp {{ number_format($itemPrice, 0, ',', '.') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <div class="text-sm text-gray-900">{{ $itemQuantity }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <div class="text-sm font-medium text-gray-900">Rp {{ number_format($itemSubtotal, 0, ',', '.') }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Order Total -->
                            <div class="mt-6 space-y-3 bg-gray-50 p-4 rounded-lg">
                                @php
                                    // Recalculate all values to ensure accuracy
                                    $calculatedTax = $calculatedSubtotal * 0.11;
                                    $calculatedServiceFee = isset($serviceFee) ? $serviceFee : 50000;
                                    $calculatedTotal = $calculatedSubtotal + $calculatedTax + $calculatedServiceFee;
                                @endphp
                                <script>
                                    // Update hidden input with correct calculated total
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.getElementById('final_total').value = {{ $calculatedTotal }};
                                    });
                                </script>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-800 font-medium">Rp {{ number_format($calculatedSubtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Pajak (11%)</span>
                                    <span class="text-gray-800 font-medium">Rp {{ number_format($calculatedTax, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Biaya Layanan</span>
                                    <span class="text-gray-800 font-medium">Rp {{ number_format($calculatedServiceFee, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3 mt-3">
                                    <div class="flex justify-between font-bold">
                                        <span class="text-gray-800">Total</span>
                                        <span class="text-gradient text-xl">Rp {{ number_format($calculatedTotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buyer Information -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-800">Data Pemesan</h2>
                        </div>
                        <button type="button" id="copy-all-btn" class="text-sm text-primary-600 font-medium flex items-center hover:text-primary-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Salin ke Semua Tiket
                        </button>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" id="full_name" name="buyer_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                        </div>
                        
                        <div>
                            <label for="identity_type" class="block text-sm font-medium text-gray-700 mb-1">Identitas <span class="text-red-500">*</span></label>
                            <div class="flex gap-3">
                                <select id="identity_type" name="identity_type" class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                                    <option value="KTP">KTP</option>
                                    <option value="SIM">SIM</option>
                                    <option value="Passport">Passport</option>
                                </select>
                                <input type="text" id="identity_number" name="identity_number" required placeholder="Nomor Identitas" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="buyer_email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                            <p class="text-xs text-gray-500 mt-1">Tiket akan dikirimkan ke email ini</p>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. Whatsapp <span class="text-red-500">*</span></label>
                            <input type="tel" id="phone" name="buyer_phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                        </div>
                    </div>
                </div>

                <!-- Ticket Holders Information -->
                @foreach($cartItems as $index => $item)
                    @php
                        $ticketName = $item['ticket_name'] ?? $item['ticket']->name ?? 'Tiket';
                        $ticketType = $item['ticket_type'] ?? $item['ticket']->type ?? '';
                        $eventData = $item['event'];
                        $eventTitle = $eventData->title ?? 'Event';
                    @endphp
                    @for($i = 0; $i < $item['quantity']; $i++)
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    <h2 class="text-xl font-bold text-gray-800">
                                        Pemilik Tiket <span class="text-primary-600">{{ $eventTitle }}</span> - 
                                        <span class="text-primary-600">{{ $ticketName }}</span> 
                                        @if($ticketType)<span class="text-sm text-gray-600">({{ $ticketType }})</span>@endif 
                                        #{{ $i + 1 }}
                                    </h2>
                                </div>
                                <button type="button" class="ticket-copy-btn text-sm text-primary-600 font-medium flex items-center" data-index="{{ $index }}-{{ $i }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    Samakan dengan data pemesan
                                </button>
                            </div>
                            <div class="p-6 space-y-4">
                                <div>
                                    <label for="holder_name_{{ $index }}_{{ $i }}" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" id="holder_name_{{ $index }}_{{ $i }}" name="holders[{{ $index }}][{{ $i }}][name]" required class="holder-name w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                                </div>
                                
                                <div>
                                    <label for="holder_identity_type_{{ $index }}_{{ $i }}" class="block text-sm font-medium text-gray-700 mb-1">Identitas <span class="text-red-500">*</span></label>
                                    <div class="flex gap-3">
                                        <select id="holder_identity_type_{{ $index }}_{{ $i }}" name="holders[{{ $index }}][{{ $i }}][identity_type]" class="holder-identity-type w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                                            <option value="KTP">KTP</option>
                                            <option value="SIM">SIM</option>
                                            <option value="Passport">Passport</option>
                                        </select>
                                        <input type="text" id="holder_identity_number_{{ $index }}_{{ $i }}" name="holders[{{ $index }}][{{ $i }}][identity_number]" required placeholder="Nomor Identitas" class="holder-identity-number flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="holder_email_{{ $index }}_{{ $i }}" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                    <input type="email" id="holder_email_{{ $index }}_{{ $i }}" name="holders[{{ $index }}][{{ $i }}][email]" required class="holder-email w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                                </div>
                                
                                <div>
                                    <label for="holder_phone_{{ $index }}_{{ $i }}" class="block text-sm font-medium text-gray-700 mb-1">No. Whatsapp <span class="text-red-500">*</span></label>
                                    <input type="tel" id="holder_phone_{{ $index }}_{{ $i }}" name="holders[{{ $index }}][{{ $i }}][phone]" required class="holder-phone w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                                </div>
                            </div>
                        </div>
                    @endfor
                @endforeach

                <!-- Payment Method -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800">Metode Pembayaran</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Payment Method Selection -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex items-center cursor-pointer">
                                    <div class="w-5 h-5 bg-primary-600 rounded-full flex items-center justify-center border-2 border-white outline outline-2 outline-primary-600 mr-3"></div>
                                    <div>
                                        <p class="font-medium text-gray-800">Kartu Kredit / Debit</p>
                                    </div>
                                </div>
                                <div class="p-4 rounded-lg border border-gray-200 flex items-center cursor-pointer">
                                    <div class="w-5 h-5 border-2 border-gray-400 rounded-full mr-3"></div>
                                    <div>
                                        <p class="font-medium text-gray-800">Transfer Bank</p>
                                    </div>
                                </div>
                                <div class="p-4 rounded-lg border border-gray-200 flex items-center cursor-pointer">
                                    <div class="w-5 h-5 border-2 border-gray-400 rounded-full mr-3"></div>
                                    <div>
                                        <p class="font-medium text-gray-800">E-Wallet</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Information -->
                            <div class="space-y-4">
                                <div>
                                    <label for="card-number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Kartu</label>
                                    <input type="text" id="card-number" name="card_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="expiry" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kadaluarsa</label>
                                        <input type="text" id="expiry" name="card_expiry" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600" placeholder="MM/YY">
                                    </div>
                                    <div>
                                        <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                        <input type="text" id="cvv" name="card_cvv" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600" placeholder="123">
                                    </div>
                                </div>
                                <div>
                                    <label for="card-name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pada Kartu</label>
                                    <input type="text" id="card-name" name="card_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600" placeholder="John Doe">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Button -->
                <div class="flex justify-center">
                    <button type="submit" class="px-8 py-3 bg-gradient-primary text-white font-bold rounded-full hover:shadow-lg transition-all">Selesaikan Pembelian</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy buyer information to ticket holder
        const copyButtons = document.querySelectorAll('.ticket-copy-btn');
        const buyerName = document.getElementById('full_name');
        const buyerIdentityType = document.getElementById('identity_type');
        const buyerIdentityNumber = document.getElementById('identity_number');
        const buyerEmail = document.getElementById('email');
        const buyerPhone = document.getElementById('phone');

        // Handler for all copy buttons
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                const holderName = document.getElementById(`holder_name_${index}`);
                const holderIdentityType = document.getElementById(`holder_identity_type_${index}`);
                const holderIdentityNumber = document.getElementById(`holder_identity_number_${index}`);
                const holderEmail = document.getElementById(`holder_email_${index}`);
                const holderPhone = document.getElementById(`holder_phone_${index}`);

                if (holderName) holderName.value = buyerName.value;
                if (holderIdentityType) holderIdentityType.value = buyerIdentityType.value;
                if (holderIdentityNumber) holderIdentityNumber.value = buyerIdentityNumber.value;
                if (holderEmail) holderEmail.value = buyerEmail.value;
                if (holderPhone) holderPhone.value = buyerPhone.value;
                
                // Add visual confirmation
                showCopyConfirmation(button);
            });
        });
        
        // Copy data to all ticket holders at once
        const copyAllBtn = document.getElementById('copy-all-btn');
        if (copyAllBtn) {
            copyAllBtn.addEventListener('click', function() {
                copyButtons.forEach(button => {
                    button.click();
                });
                
                // Show global confirmation message
                const message = document.createElement('div');
                message.className = 'fixed bottom-4 right-4 bg-primary-600 text-white px-4 py-2 rounded-md shadow-lg z-50';
                message.textContent = 'Data pemesan disalin ke semua tiket';
                document.body.appendChild(message);
                
                setTimeout(() => {
                    message.remove();
                }, 3000);
            });
        }
        
        // Show temporary confirmation when data is copied
        function showCopyConfirmation(button) {
            // Get the original text
            const originalText = button.innerHTML;
            
            // Change text to confirmation
            button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Data disalin!
            `;
            
            // Add success style
            button.classList.add('text-green-600');
            
            // Reset after 2 seconds
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('text-green-600');
            }, 2000);
        }
        
        // Calculate total as user enters information
        updateFinalTotal();
        
        // Validate form before submission
        const checkoutForm = document.getElementById('checkout-form');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default submission
                
                const buyerName = document.getElementById('full_name').value;
                const buyerEmail = document.getElementById('email').value;
                const buyerPhone = document.getElementById('phone').value;
                
                if (!buyerName || !buyerEmail || !buyerPhone) {
                    alert('Mohon lengkapi data pemesan terlebih dahulu.');
                    return false;
                }
                
                // Ensure the form is submitted as POST
                this.method = 'POST';
                this.submit();
            });
        }
    });
    
    // Update hidden input with correct calculated total
    function updateFinalTotal() {
        document.getElementById('final_total').value = {{ $calculatedTotal }};
    }
</script>
@endsection 