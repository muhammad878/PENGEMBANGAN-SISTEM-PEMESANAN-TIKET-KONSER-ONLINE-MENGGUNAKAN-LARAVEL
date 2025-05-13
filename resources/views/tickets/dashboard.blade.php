@extends('layouts.app')

@section('title', 'Tiket Saya - KonserKUY')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tiket Saya</h1>
            <a href="{{ route('tickets.history') }}" class="text-pink-600 hover:text-pink-700 font-medium">
                Lihat Semua Riwayat &rarr;
            </a>
        </div>
        
        <!-- Tiket Aktif -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Tiket Aktif</h2>
            
            @if($activeTickets->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeTickets as $ticket)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
                            <div class="p-5">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $ticket->event_title }}</h3>
                                        <p class="text-gray-600 text-sm">{{ \Carbon\Carbon::parse($ticket->date)->format('d M Y, H:i') }}</p>
                                    </div>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Aktif</span>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600"><span class="font-medium">Lokasi:</span> {{ $ticket->location }}</p>
                                    <p class="text-sm text-gray-600"><span class="font-medium">Tipe Tiket:</span> {{ $ticket->ticket_name }}</p>
                                    <p class="text-sm text-gray-600"><span class="font-medium">Kode:</span> {{ $ticket->ticket_code }}</p>
                                </div>
                                
                                <div class="text-center mb-4">
                                    @if($ticket->qr_code_path)
                                        <img src="{{ asset('storage/' . $ticket->qr_code_path) }}" alt="QR Code" class="h-32 mx-auto">
                                    @else
                                        <div class="p-6 bg-gray-100 rounded-md flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="text-pink-600 hover:text-pink-700 font-medium text-sm">
                                        Lihat Detail
                                    </a>
                                    <a href="{{ route('tickets.download', $ticket->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-xs rounded-md shadow-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        E-Ticket
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak Ada Tiket Aktif</h3>
                        <p class="text-gray-500 mb-6">Anda belum memiliki tiket konser yang aktif</p>
                        <a href="{{ route('events') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            Cari Konser
                        </a>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Tiket Digunakan -->
        @if($usedTickets->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tiket Digunakan</h2>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Konser</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Tiket</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Konser</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Digunakan Pada</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($usedTickets as $ticket)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $ticket->event_title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $ticket->ticket_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($ticket->date)->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($ticket->used_at)->format('d M Y, H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-pink-600 hover:text-pink-700 text-sm">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Tiket Kadaluarsa -->
        @if($expiredTickets->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tiket Kadaluarsa</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($expiredTickets->take(3) as $ticket)
                        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-gray-400">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-md font-semibold text-gray-800">{{ $ticket->event_title }}</h3>
                                    <p class="text-gray-600 text-xs">{{ \Carbon\Carbon::parse($ticket->date)->format('d M Y') }}</p>
                                </div>
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Kadaluarsa</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2"><span class="font-medium">Tipe:</span> {{ $ticket->ticket_name }}</p>
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-pink-600 hover:text-pink-700 text-sm">Lihat Detail</a>
                        </div>
                    @endforeach
                </div>
                
                @if($expiredTickets->count() > 3)
                    <div class="mt-4 text-center">
                        <a href="{{ route('tickets.history') }}" class="text-pink-600 hover:text-pink-700 text-sm font-medium">
                            Lihat {{ $expiredTickets->count() - 3 }} tiket kadaluarsa lainnya
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection 