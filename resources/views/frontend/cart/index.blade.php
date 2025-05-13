@extends('frontend.layouts.app')

@section('title', 'Shopping Cart - KonserKUY')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gradient mb-2">Shopping Cart</h1>
                <p class="text-gray-600">Keranjang Belanja Anda</p>
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

            <!-- Cart Items -->
            @if(count($cartItems) > 0)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800">Items in Cart ({{ count($cartItems) }})</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            @foreach($cartItems as $item)
                                <div class="flex flex-col md:flex-row md:items-start gap-4 pb-6 border-b border-gray-200">
                                    <div class="w-full md:w-24 h-24 bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ $item['ticket']->event->poster_path ? asset($item['ticket']->event->poster_path) : asset('images/default-event.jpg') }}" 
                                            alt="{{ $item['ticket']->event->title }}" class="w-full h-16 object-cover rounded-lg"
                                            onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}'; console.log('Image failed to load, using default')">
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-2">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-800">{{ $item['ticket']->event->title }}</h3>
                                                <p class="text-gray-600 text-sm">{{ $item['ticket']->event->location }}</p>
                                                <div class="text-sm text-gray-500 mt-1">{{ $item['ticket']->event->date->format('F d, Y - H:i') }}</div>
                                                <div class="text-sm text-primary-600 font-medium mt-1">{{ $item['ticket']->ticket_type }} Ticket</div>
                                            </div>
                                            <div class="mt-2 md:mt-0 text-right">
                                                <span class="font-bold text-gradient text-xl">Rp {{ number_format($item['ticket']->price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between mt-4">
                                            <div class="flex items-center">
                                                <form action="{{ route('cart.update') }}" method="post" class="flex items-center">
                                                    @csrf
                                                    <input type="hidden" name="ticket_id" value="{{ $item['ticket']->id }}">
                                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mr-3">Qty:</label>
                                                    <select name="quantity" id="quantity" class="w-16 rounded-md border-gray-300 focus:ring-primary-500 focus:border-primary-500 text-sm" onchange="this.form.submit()">
                                                        @for($i = 1; $i <= min(10, $item['ticket']->remaining); $i++)
                                                            <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </form>
                                                <div class="ml-4 text-gray-700">
                                                    <span class="font-medium">Subtotal:</span> Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <form action="{{ route('cart.remove') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="ticket_id" value="{{ $item['ticket']->id }}">
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800">Order Summary</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-800 font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (11%)</span>
                                <span class="text-gray-800 font-medium">Rp {{ number_format($total * 0.11, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Service Fee</span>
                                <span class="text-gray-800 font-medium">Rp 50.000</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 mt-3">
                                <div class="flex justify-between font-bold">
                                    <span class="text-gray-800">Total</span>
                                    <span class="text-gradient text-xl">Rp {{ number_format($total + ($total * 0.11) + 50000, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center">
                    <form action="{{ route('cart.clear') }}" method="post">
                        @csrf
                        <button type="submit" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-full hover:bg-gray-50 transition">
                            Clear Cart
                        </button>
                    </form>
                    <a href="{{ route('checkout') }}" class="px-8 py-3 bg-gradient-primary text-white font-bold rounded-full hover:shadow-lg transition-all">
                        Proceed to Checkout
                    </a>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                    <div class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Your Cart is Empty</h2>
                    <p class="text-gray-600 mb-8">Looks like you haven't added any tickets to your cart yet.</p>
                    <a href="{{ route('events') }}" class="px-6 py-3 bg-gradient-primary text-white font-bold rounded-full hover:shadow-lg transition-all inline-flex items-center">
                        <span>Explore Events</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 