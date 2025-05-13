@extends('frontend.layouts.app')

@section('title', 'Venue Konser - KonserKUY')

@section('content')
<div class="bg-slate-50">
    <!-- Page Header -->
    <div class="bg-gradient-primary text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute animate-float" style="top: 10%; left: 5%;">
                <svg class="w-20 h-20 text-white opacity-20" viewBox="0 0 80 80" fill="currentColor">
                    <circle cx="40" cy="40" r="40" />
                </svg>
            </div>
            <div class="absolute animate-float animation-delay-500" style="top: 20%; right: 10%;">
                <svg class="w-32 h-32 text-white opacity-10" viewBox="0 0 80 80" fill="currentColor">
                    <circle cx="40" cy="40" r="40" />
                </svg>
            </div>
            <div class="absolute bottom-0 left-0 right-0">
                <svg class="w-full text-slate-50" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="currentColor" opacity=".25"></path>
                    <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="currentColor" opacity=".5"></path>
                </svg>
            </div>
        </div>
        <div class="container mx-auto px-4 py-16 relative">
            <h1 class="text-4xl md:text-5xl font-bold mb-2 animate-fade-in-up">Venue Konser</h1>
            <p class="text-xl opacity-90 animate-fade-in-up">Temukan konser berdasarkan lokasi penyelenggaraan</p>
        </div>
    </div>

    <!-- Venues List -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @if($venues->count() > 0)
                @foreach($venues as $venue)
                @php
                    // Cari event pertama dengan venue_image_path
                    $venueImageEvent = App\Models\Event::where('location', 'like', "%{$venue->name}%")
                        ->whereNotNull('venue_image_path')
                        ->first();
                    
                    $venueImagePath = $venueImageEvent ? $venueImageEvent->venue_image_path : null;
                @endphp
                <a href="{{ route('venues.show', $venue->slug) }}" class="bg-white rounded-2xl overflow-hidden shadow-xl hover-lift transition-all duration-300 group">
                    <div class="h-48 bg-cover bg-center relative" 
                        @if($venueImagePath)
                            style="background-image: url('{{ asset($venueImagePath) }}');"
                        @else
                            style="background-image: url('https://images.unsplash.com/photo-{{ 1500000000 + $loop->index * 10000000 }}?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1567&q=80');"
                        @endif
                    >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <h3 class="text-xl font-bold text-white mb-1">{{ $venue->name }}</h3>
                            <p class="text-white/80 text-sm">
                                @php
                                    if (strpos($venue->name, ',') !== false) {
                                        $cityParts = explode(',', $venue->name);
                                        echo trim(end($cityParts));
                                    } else {
                                        echo $venue->name;
                                    }
                                @endphp
                            </p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-primary rounded-full flex items-center justify-center text-white shadow-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-600 text-sm">Kapasitas</p>
                                <p class="font-semibold text-slate-800">{{ number_format($venue->capacity, 0, ',', '.') }} orang</p>
                            </div>
                        </div>
                        <p class="text-slate-600 mb-4">Venue {{ $venue->type }} untuk berbagai acara musik</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-primary-600">{{ $venue->event_count }} konser</span>
                            <span class="px-3 py-1 bg-primary-50 text-primary-600 text-xs font-medium rounded-full">{{ $venue->type }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            @else
                <div class="col-span-full bg-white rounded-2xl p-12 text-center shadow-xl">
                    <div class="bg-slate-100 rounded-full p-6 inline-flex mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-3">Tidak ada venue saat ini</h3>
                    <p class="text-slate-600 mb-6 max-w-md mx-auto">Kami belum memiliki daftar venue untuk konser. Silakan cek kembali nanti.</p>
                    <a href="{{ route('events') }}" class="btn-gradient text-white px-6 py-3 rounded-lg hover:shadow-lg transition-all inline-flex items-center justify-center">
                        <span>Lihat Semua Konser</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Map Section -->
        <div class="mt-16 bg-white rounded-2xl shadow-xl p-8 md:p-10 hover-lift">
            <h2 class="text-3xl font-bold text-gradient mb-8">Peta Venue Konser di Indonesia</h2>
            <div class="bg-slate-100 rounded-xl h-96 flex items-center justify-center">
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Peta Interaktif</h3>
                    <p class="text-slate-600 max-w-md mx-auto">Segera hadir! Kami sedang mengembangkan peta interaktif untuk semua venue konser di Indonesia.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 