<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tiket Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <!-- Filter and Search -->
                <div class="flex flex-col md:flex-row justify-between mb-6">
                    <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 mb-4 md:mb-0">
                        <a href="{{ route('tickets.index', ['filter' => 'active']) }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request('filter') == 'active' ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Active Tickets
                        </a>
                        <a href="{{ route('tickets.index', ['filter' => 'used']) }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request('filter') == 'used' ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Used Tickets
                        </a>
                        <a href="{{ route('tickets.index', ['filter' => 'expired']) }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request('filter') == 'expired' ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            Expired Tickets
                        </a>
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ !request('filter') ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            All Tickets
                        </a>
                    </div>
                    
                    <form action="{{ route('tickets.index') }}" method="GET" class="flex">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama acara" class="border-gray-300 focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <button type="submit" class="ml-2 px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                            Cari
                        </button>
                    </form>
                </div>
                
                @if ($tickets->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($tickets as $ticket)
                            <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-200">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                        @if ($ticket->order && $ticket->order->event)
                                            {{ $ticket->order->event->title }}
                                        @elseif ($ticket->orderItem && $ticket->orderItem->event)
                                            {{ $ticket->orderItem->event->title }}
                                        @else
                                            Unknown Event
                                        @endif
                                    </h3>
                                    
                                    <div class="text-sm text-gray-600 mb-4">
                                        <p class="mb-1">
                                            <span class="font-medium">Kode Tiket:</span> {{ $ticket->code }}
                                        </p>
                                        <p class="mb-1">
                                            <span class="font-medium">Tanggal Acara:</span>
                                            @if ($ticket->event_date)
                                                {{ $ticket->event_date->format('j F Y, H:i') }}
                                            @elseif ($ticket->order && $ticket->order->event && $ticket->order->event->date)
                                                {{ \Carbon\Carbon::parse($ticket->order->event->date)->format('j F Y, H:i') }}
                                            @elseif ($ticket->orderItem && $ticket->orderItem->event && $ticket->orderItem->event->date)
                                                {{ \Carbon\Carbon::parse($ticket->orderItem->event->date)->format('j F Y, H:i') }}
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                        <p class="mb-1">
                                            <span class="font-medium">Status:</span>
                                            @if (isset($ticket->is_used) && $ticket->is_used)
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Sudah Digunakan</span>
                                            @elseif (isset($ticket->status) && $ticket->status == 'used')
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Sudah Digunakan</span>
                                            @elseif ($ticket->event_date && $ticket->event_date < now())
                                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Kadaluarsa</span>
                                            @elseif (isset($ticket->status) && $ticket->status == 'expired')
                                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Kadaluarsa</span>
                                            @else
                                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Aktif</span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="flex justify-between mt-4">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-sm text-pink-600 hover:text-pink-800">
                                            Lihat Detail
                                        </a>
                                        <a href="{{ route('tickets.download', $ticket) }}" class="text-sm bg-pink-600 text-white px-3 py-1 rounded hover:bg-pink-700">
                                            Unduh PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $tickets->links() }}
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
        </div>
    </div>
</x-app-layout> 