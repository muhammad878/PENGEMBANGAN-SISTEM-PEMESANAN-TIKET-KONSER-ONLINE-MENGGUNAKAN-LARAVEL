@extends('layouts.organizer')

@section('header')
    Edit Event
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <!-- Display Errors -->
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 002 0V9a1 1 0 00-2 0z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 9a1 1 0 012 0v4a1 1 0 01-2 0V9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <form action="{{ route('organizer.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Nama Event -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Event <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $event->title) }}" required 
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Lokasi Event -->
                <div class="mb-6">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" required 
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Google Maps Embed -->
                <div class="mb-6">
                    <label for="maps_link" class="block text-sm font-medium text-gray-700 mb-1">Link Google Maps <small class="text-gray-500">(opsional)</small></label>
                    <textarea name="maps_link" id="maps_link" rows="4" 
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('maps_link', $event->maps_link) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Masukkan kode embed Google Maps (iframe). Contoh: &lt;iframe src="https://www.google.com/maps/embed?pb=..."&gt;&lt;/iframe&gt;</p>
                    @if($event->maps_link)
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg overflow-hidden">
                            <p class="text-xs text-gray-500 mb-2">Preview Maps:</p>
                            <div class="maps-preview">
                                {!! $event->maps_link !!}
                            </div>
                        </div>
                    @endif
                    @error('maps_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Kategori Event -->
                <div class="mb-6">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="category" required 
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Pilih Kategori</option>
                        <option value="K-Pop" {{ old('category', $event->category) == 'K-Pop' ? 'selected' : '' }}>K-Pop</option>
                        <option value="Pop" {{ old('category', $event->category) == 'Pop' ? 'selected' : '' }}>Pop</option>
                        <option value="Koplo" {{ old('category', $event->category) == 'Koplo' ? 'selected' : '' }}>Koplo</option>
                        <option value="Indie" {{ old('category', $event->category) == 'Indie' ? 'selected' : '' }}>Indie</option>
                        <option value="Classical" {{ old('category', $event->category) == 'Classical' ? 'selected' : '' }}>Classical</option>
                        <option value="Festival" {{ old('category', $event->category) == 'Festival' ? 'selected' : '' }}>Festival</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Tanggal & Waktu Event -->
                <div class="mb-6">
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="event_date" id="event_date" 
                        value="{{ old('event_date', $event->event_date ? $event->event_date->format('Y-m-d\TH:i') : '') }}" required 
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('event_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Grid untuk harga dan jumlah tiket -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Harga Tiket -->
                    <div>
                        <label for="ticket_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Tiket (Rp) <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="ticket_price" id="ticket_price" value="{{ old('ticket_price', $event->ticket_price) }}" min="0" required
                                class="block w-full pl-10 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        @error('ticket_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Jumlah Tiket -->
                    <div>
                        <label for="ticket_quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tiket <span class="text-red-500">*</span></label>
                        <input type="number" name="ticket_quantity" id="ticket_quantity" value="{{ old('ticket_quantity', $event->ticket_quantity) }}" min="1" required
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('ticket_quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Deskripsi Event -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="5" required
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Gambar Event -->
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Poster Event</label>
                    <div class="mt-1 flex items-center">
                        @if($event->poster_path)
                        <div class="w-full mb-2">
                            <div class="relative h-64 w-full overflow-hidden rounded-lg">
                                <img src="{{ asset($event->poster_path) }}" alt="{{ $event->title }}" class="h-full w-full object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                    <span class="text-white text-sm">Poster event saat ini</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        <input type="file" name="image" id="image" class="mt-1 block w-full" accept="image/*"
                            class="focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Upload poster event baru dengan format gambar (JPG, PNG, GIF). Maks 2MB. Kosongkan jika tidak ingin mengubah poster.</p>
                    @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Gambar Venue/Lokasi -->
                <div class="mb-6">
                    <label for="venue_image" class="block text-sm font-medium text-gray-700 mb-1">Foto Venue/Lokasi <small class="text-gray-500">(opsional)</small></label>
                    <div class="mt-1 flex items-center">
                        @if($event->venue_image_path)
                        <div class="w-full mb-2">
                            <div class="relative h-64 w-full overflow-hidden rounded-lg">
                                <img src="{{ asset($event->venue_image_path) }}" alt="Venue {{ $event->title }}" class="h-full w-full object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                    <span class="text-white text-sm">Foto venue saat ini</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        <input type="file" name="venue_image" id="venue_image" class="mt-1 block w-full" accept="image/*"
                            class="focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Upload foto venue/lokasi baru dengan format gambar (JPG, PNG, GIF). Maks 2MB. Kosongkan jika tidak ingin mengubah foto venue.</p>
                    @error('venue_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between mt-8">
                    <p class="text-sm text-gray-500">
                        <span class="text-red-500">*</span> Wajib diisi
                    </p>
                    <div class="flex space-x-2">
                        <a href="{{ route('organizer.events.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Perbarui Event
                        </button>
                    </div>
                </div>
                
                <div class="mt-4 text-sm text-gray-600">
                    <p>Catatan: Perubahan pada event mungkin perlu direview ulang oleh admin jika diperlukan.</p>
                </div>
            </form>
        </div>
    </div>
@endsection 