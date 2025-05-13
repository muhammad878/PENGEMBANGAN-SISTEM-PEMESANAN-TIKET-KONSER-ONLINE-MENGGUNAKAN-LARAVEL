@extends('layouts.organizer')

@section('header')
    Edit Tiket
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Edit Tiket: {{ $ticket->ticket_type }}</h1>
                <p class="mt-1 text-sm text-gray-500">Update informasi untuk kategori tiket ini</p>
            </div>
            <a href="{{ route('organizer.tickets.index', $event->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Tiket
            </a>
        </div>
        
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <form method="POST" action="{{ route('organizer.tickets.update', ['event' => $event->id, 'ticket' => $ticket->id]) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $ticket->ticket_type) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipe Tiket</label>
                            <select name="type" id="type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="regular" {{ $ticket->type == 'regular' ? 'selected' : '' }}>Regular</option>
                                <option value="vip" {{ $ticket->type == 'vip' ? 'selected' : '' }}>VIP</option>
                                <option value="early_bird" {{ $ticket->type == 'early_bird' ? 'selected' : '' }}>Early Bird</option>
                                <option value="student" {{ $ticket->type == 'student' ? 'selected' : '' }}>Student</option>
                                <option value="other" {{ $ticket->type == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $ticket->price) }}" min="0" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah Tiket</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $ticket->quota) }}" min="{{ $ticket->sold }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @if($ticket->sold > 0)
                                <p class="mt-1 text-xs text-amber-600">Tiket terjual: {{ $ticket->sold }}. Jumlah tiket tidak dapat dikurangi di bawah jumlah yang sudah terjual.</p>
                            @endif
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="active" {{ $ticket->status == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $ticket->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="py-3 bg-gray-50 text-right">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Penjualan</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-gray-50 p-4 rounded-md">
                        <span class="block text-gray-500">Total Tiket</span>
                        <span class="text-xl font-medium">{{ $ticket->quota }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <span class="block text-gray-500">Tiket Tersisa</span>
                        <span class="text-xl font-medium">{{ $ticket->quota - $ticket->sold }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <span class="block text-gray-500">Tiket Terjual</span>
                        <span class="text-xl font-medium">{{ $ticket->sold }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 