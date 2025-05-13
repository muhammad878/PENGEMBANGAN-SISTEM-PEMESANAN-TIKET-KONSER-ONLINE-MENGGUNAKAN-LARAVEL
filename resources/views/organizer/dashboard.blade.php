@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.organizer')

@section('header')
    Dashboard
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="mt-1 text-sm text-gray-500">Ini adalah dashboard Event Organizer. Di sini Anda dapat mengelola event-event yang Anda adakan.</p>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Total Event</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $eventsCount ?? 0 }}</p>
                <p class="mt-1 text-sm text-gray-500">{{ $activeEventsCount ?? 0 }} event aktif</p>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Total Penjualan</h3>
                <p class="text-2xl font-bold text-gray-900">Rp{{ number_format($totalSales ?? 0, 0, ',', '.') }}</p>
                <p class="mt-1 text-sm text-gray-500">Dari semua event</p>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Tiket Terjual</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $totalTicketsSold ?? 0 }}</p>
                <p class="mt-1 text-sm text-gray-500">Dari semua event</p>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Pengunjung</h3>
                <p class="text-2xl font-bold text-gray-900">--</p>
                <p class="mt-1 text-sm text-gray-500">Data belum tersedia</p>
            </div>
        </div>

        <!-- Menu Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">Event Saya</h3>
                <p class="mt-2 text-sm text-gray-500">Lihat dan kelola semua event yang telah Anda buat.</p>
                <div class="mt-4">
                    <a href="{{ route('organizer.events.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Lihat Events →
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">Buat Event</h3>
                <p class="mt-2 text-sm text-gray-500">Buat event baru dengan mudah.</p>
                <div class="mt-4">
                    <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Buat Event Baru →
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">Laporan Penjualan</h3>
                <p class="mt-2 text-sm text-gray-500">Lihat laporan penjualan tiket event yang Anda adakan.</p>
                <div class="mt-4">
                    <a href="{{ route('organizer.orders') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Lihat Laporan →
                    </a>
                </div>
            </div>
        </div>

        <!-- Event Terbaru -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Event Terbaru</h3>
            </div>
            <div class="bg-white divide-y divide-gray-200">
                @if(isset($recentEvents) && count($recentEvents) > 0)
                    @foreach($recentEvents as $event)
                    <div class="p-6 flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                            @if($event->poster_path)
                                <img src="{{ Storage::url($event->poster_path) }}" alt="{{ $event->title }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $event->title }}</h4>
                                    <p class="text-sm text-gray-500">{{ $event->event_date ? $event->event_date->format('d M Y, H:i') : 'Tanggal belum diatur' }}</p>
                                </div>
                                <div>
                                    {!! $event->status_badge !!}
                                </div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('organizer.events.show', $event->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Detail
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="p-6 text-center">
                        <p class="text-gray-500">Belum ada event yang dibuat</p>
                        <a href="{{ route('organizer.events.create') }}" class="mt-2 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Buat Event Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Transaksi Terbaru</h3>
            </div>
            <div class="bg-white divide-y divide-gray-200">
                @if(isset($recentTransactions) && count($recentTransactions) > 0)
                    @foreach($recentTransactions as $transaction)
                    <div class="p-6 flex items-center">
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Order #{{ $transaction->order_number ?? $transaction->id }}</h4>
                                    <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $transaction->status == 'completed' ? 'Selesai' : 'Pending' }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">Event: {{ $transaction->event_name }}</p>
                                <p class="text-sm font-medium text-gray-900">Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="p-6 text-center">
                        <p class="text-gray-500">Belum ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection 