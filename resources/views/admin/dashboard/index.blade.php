@extends('layouts.admin')

@section('header')
    Dashboard Admin
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Jumlah Event Aktif -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Event Aktif</div>
                    <div class="text-3xl font-semibold">{{ $eventCount ?? 0 }}</div>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.events.validation') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Lihat semua event →
                </a>
            </div>
        </div>

        <!-- Tiket Terjual -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Tiket Terjual</div>
                    <div class="text-3xl font-semibold">{{ $ticketsSold ?? 0 }}</div>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.reports.transactions') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    Lihat transaksi →
                </a>
            </div>
        </div>

        <!-- User Aktif -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">User Aktif</div>
                    <div class="text-3xl font-semibold">{{ $userCount ?? 0 }}</div>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Kelola user →
                </a>
            </div>
        </div>
    </div>

    <!-- Grafik Transaksi Bulanan -->
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Grafik Transaksi Bulanan</h3>
        <div class="h-64 bg-gray-100 flex items-center justify-center">
            <p class="text-gray-500">Grafik transaksi akan ditampilkan di sini</p>
            <!-- Di sini nantinya akan diintegrasikan dengan library chart seperti Chart.js -->
        </div>
    </div>

    <!-- Event Terbaru yang Membutuhkan Validasi -->
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Event Menunggu Validasi</h3>
        
        @if(isset($pendingEvents) && count($pendingEvents) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Event
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Penyelenggara
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Event
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pendingEvents ?? [] as $event)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $event->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $event->organizer_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $event->event_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.events.show', $event->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-gray-500">Tidak ada event yang menunggu validasi</p>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('admin.events.validation') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                Lihat semua event yang menunggu validasi →
            </a>
        </div>
    </div>
@endsection 