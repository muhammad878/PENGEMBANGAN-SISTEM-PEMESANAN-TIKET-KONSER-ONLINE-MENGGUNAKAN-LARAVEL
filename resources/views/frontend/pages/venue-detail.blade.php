@extends('frontend.layouts.app')

@section('title', $venueName . ' - Venue Konser - KonserKUY')

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
            <div class="flex items-center mb-4">
                <a href="{{ route('venues') }}" class="mr-4 bg-white/20 p-2 rounded-full hover:bg-white/30 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                <span class="text-white/80 text-sm">Venues</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-2 animate-fade-in-up">{{ $venueName }}</h1>
            <p class="text-xl opacity-90 animate-fade-in-up">Konser yang diselenggarakan di {{ $venueName }}</p>
            
            <div class="flex gap-4 mt-6">
                <div class="bg-white/20 px-3 py-2 rounded-lg backdrop-blur-sm text-sm">
                    <span class="font-semibold">{{ $venue->event_count }}</span> Events
                </div>
                <div class="bg-white/20 px-3 py-2 rounded-lg backdrop-blur-sm text-sm">
                    <span class="font-semibold">{{ number_format($venue->capacity, 0, ',', '.') }}</span> Kapasitas
                </div>
                <div class="bg-white/20 px-3 py-2 rounded-lg backdrop-blur-sm text-sm">
                    <span class="font-semibold">{{ $venue->upcoming_events }}</span> Upcoming Events
                </div>
            </div>
        </div>
    </div>

    <!-- Venue Details -->
    <div class="container mx-auto px-4 -mt-10 relative z-10">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Left: Venue Image -->
                <div class="h-72 md:h-auto bg-cover bg-center" 
                    @if(isset($venueImagePath))
                        style="background-image: url('{{ asset($venueImagePath) }}');"
                    @else
                        style="background-image: url('https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80');"
                    @endif
                >
                </div>
                
                <!-- Right: Venue Details -->
                <div class="p-8">
                    <div class="inline-flex items-center px-3 py-1 bg-primary-50 text-primary-600 rounded-full text-sm font-medium mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span>
                            @php
                                // Tangani kasus dengan dan tanpa koma
                                if (strpos($venueName, ',') !== false) {
                                    $cityParts = explode(',', $venueName);
                                    echo strtoupper(trim(end($cityParts))) . ", INDONESIA";
                                } else {
                                    // Jika tidak ada koma, tampilkan seluruh nama venue
                                    echo strtoupper($venueName) . ", INDONESIA";
                                }
                            @endphp
                        </span>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-slate-800 mb-4">About {{ $venueName }}</h2>
                    
                    <p class="text-slate-600 mb-6">
                        {{ $venueName }} adalah salah satu venue konser terkemuka di Indonesia yang menampilkan berbagai jenis acara dan pertunjukan. 
                        Dengan kapasitas hingga {{ number_format($venue->capacity, 0, ',', '.') }} pengunjung, venue ini telah menjadi pilihan utama bagi para promotor acara dan penggemar musik.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-500 mb-1">Tipe Venue</h3>
                            <p class="text-slate-800">{{ $venue->type }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-500 mb-1">Kapasitas</h3>
                            <p class="text-slate-800">{{ number_format($venue->capacity, 0, ',', '.') }} orang</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-500 mb-1">Fasilitas</h3>
                            <p class="text-slate-800">Parkir, Food Court, VIP Area</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-500 mb-1">Kontak</h3>
                            <p class="text-slate-800">0{{ rand(800, 899) }}-{{ rand(1000, 9999) }}-{{ rand(1000, 9999) }}</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-primary-50 text-primary-600 rounded-lg font-medium hover:bg-primary-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd" />
                            </svg>
                            <span>Directions</span>
                        </a>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-primary-50 text-primary-600 rounded-lg font-medium hover:bg-primary-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            <span>Contact</span>
                        </a>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-primary-50 text-primary-600 rounded-lg font-medium hover:bg-primary-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                            </svg>
                            <span>Share</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps -->
    @if(isset($mapsLink) && $mapsLink)
    <div class="container mx-auto px-4 mb-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gradient mb-4">Lokasi {{ $venueName }}</h2>
                <div class="maps-container rounded-lg overflow-hidden">
                    <style>
                        .maps-container iframe {
                            width: 100%;
                            min-height: 450px;
                            border: 0;
                        }
                    </style>
                    {!! $mapsLink !!}
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Events Listing -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gradient">{{ $events->total() }} Events at {{ $venueName }}</h2>
            <div class="flex gap-2">
                <button class="px-3 py-2 bg-white text-primary-600 rounded-lg font-medium hover:bg-primary-50 transition-colors border border-gray-200 shadow-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Filter
                </button>
                <button class="px-3 py-2 bg-white text-primary-600 rounded-lg font-medium hover:bg-primary-50 transition-colors border border-gray-200 shadow-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
                    </svg>
                    Sort
                </button>
            </div>
        </div>

        @if($events->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($events as $event)
                <div class="bg-white rounded-2xl overflow-hidden shadow-xl hover-lift transition-all duration-300">
                    <div class="relative">
                        <img src="{{ $event->poster_path ? asset($event->poster_path) : asset('images/default-event.jpg') }}"
                            alt="{{ $event->title }}" class="w-full h-52 object-cover"
                            onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}'; console.log('Image failed to load, using default')">
                        <div class="absolute top-0 left-0 mt-4 ml-4">
                            <span class="px-3 py-1 bg-gradient-primary text-white text-xs font-bold rounded-full shadow-lg">{{ $event->category }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-slate-600 text-sm">{{ $event->date->format('d M Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('events.show', $event->slug) }}" class="block">
                            <h3 class="text-xl font-bold text-slate-800 mb-2 hover:text-primary-600 transition">{{ $event->title }}</h3>
                        </a>
                        <p class="text-slate-600 text-sm mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            {{ $venueName }}
                        </p>
                        <p class="text-slate-600 text-sm mb-4">{{ \Illuminate\Support\Str::limit($event->description, 80) }}</p>
                        <div class="flex justify-between items-center mt-4">
                            <span class="font-bold text-gradient text-lg">Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</span>
                            <a href="{{ route('events.show', $event->slug) }}" class="px-4 py-2 bg-slate-100 text-primary-600 rounded-lg font-medium hover:bg-primary-50 transition-colors">Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $events->links() }}
            </div>
        @else
            <div class="bg-white rounded-2xl p-12 text-center shadow-xl">
                <div class="bg-slate-100 rounded-full p-6 inline-flex mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-3">Tidak ada konser di {{ $venueName }} saat ini</h3>
                <p class="text-slate-600 mb-6 max-w-md mx-auto">Kami belum memiliki konser untuk venue ini. Silakan cek venue lain atau kembali lagi nanti.</p>
                <a href="{{ route('events') }}" class="btn-gradient text-white px-6 py-3 rounded-lg hover:shadow-lg transition-all inline-flex items-center justify-center">
                    <span>Lihat Semua Konser</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 