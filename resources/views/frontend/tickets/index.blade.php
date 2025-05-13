@extends('frontend.layouts.app')

@section('title', 'Tiket Saya - KonserKUY')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gradient mb-2">Tiket Saya</h1>
                <p class="text-gray-600">Kelola dan lihat tiket konser yang sudah Anda beli</p>
            </div>

            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @endif

            <!-- Ticket Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Total Tiket</div>
                            <div class="text-xl font-bold">{{ $totalTickets ?? 0 }}</div>
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
                            <div class="text-xl font-bold">{{ $activeTickets ?? 0 }}</div>
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
                            <div class="text-xl font-bold">{{ $usedTickets ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets List -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">Daftar Tiket</h2>
                </div>
                
                @if(isset($tickets) && $tickets->count() > 0)
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($tickets as $ticket)
                            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-200">
                                @if(isset($ticket->order) && isset($ticket->order->event) && isset($ticket->order->event->image))
                                    <div class="h-40 overflow-hidden">
                                        <img src="{{ asset($ticket->order->event->image) }}" alt="{{ $ticket->order->event->title ?? 'Concert Image' }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="h-40 bg-gray-200 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                        @if(isset($ticket->order) && isset($ticket->order->event))
                                            {{ $ticket->order->event->title ?? 'Konser' }}
                                        @else
                                            {{ 'Konser #' . $ticket->code }}
                                        @endif
                                    </h3>
                                    
                                    <div class="text-sm text-gray-600 mb-4">
                                        <p class="mb-1">
                                            <span class="font-medium">Kode Tiket:</span> {{ $ticket->code }}
                                        </p>
                                        <p class="mb-1">
                                            <span class="font-medium">Tanggal Acara:</span>
                                            @if(isset($ticket->event_date))
                                                {{ \Carbon\Carbon::parse($ticket->event_date)->format('j F Y, H:i') }}
                                            @elseif(isset($ticket->order) && isset($ticket->order->event) && isset($ticket->order->event->date))
                                                {{ \Carbon\Carbon::parse($ticket->order->event->date)->format('j F Y, H:i') }}
                                            @else
                                                Tidak tersedia
                                            @endif
                                        </p>
                                        <p class="mb-1">
                                            <span class="font-medium">Status:</span>
                                            @if(isset($ticket->is_used) && $ticket->is_used)
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Sudah Digunakan</span>
                                            @elseif(isset($ticket->status) && $ticket->status == 'used')
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Sudah Digunakan</span>
                                            @elseif(isset($ticket->event_date) && \Carbon\Carbon::parse($ticket->event_date) < now())
                                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Kadaluarsa</span>
                                            @elseif(isset($ticket->status) && $ticket->status == 'expired')
                                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Kadaluarsa</span>
                                            @else
                                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Aktif</span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="flex justify-between mt-4">
                                        <a href="{{ route('ticket.view', $ticket->id) }}" class="text-sm text-pink-600 hover:text-pink-800">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- No Tickets Found -->
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada tiket ditemukan</h3>
                        <p class="text-gray-500 mb-6">Anda belum memiliki tiket.</p>
                        <a href="{{ route('events') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            Lihat Konser
                        </a>
                    </div>
                @endif
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