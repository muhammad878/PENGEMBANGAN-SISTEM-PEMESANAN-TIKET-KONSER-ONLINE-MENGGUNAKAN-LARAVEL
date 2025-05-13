@extends('frontend.layouts.app')

@section('title', $category->name . ' - Kategori Konser - KonserKUY')

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
                <a href="{{ route('categories') }}" class="mr-4 bg-white/20 p-2 rounded-full hover:bg-white/30 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                <span class="text-white/80 text-sm">Kategori</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-2 animate-fade-in-up">{{ $category->name }}</h1>
            <p class="text-xl opacity-90 animate-fade-in-up">{{ $category->description }}</p>
            
            <div class="flex gap-4 mt-6">
                <div class="bg-white/20 px-3 py-2 rounded-lg backdrop-blur-sm text-sm">
                    <span class="font-semibold">{{ $events->total() }}</span> Events
                </div>
                <div class="bg-white/20 px-3 py-2 rounded-lg backdrop-blur-sm text-sm">
                    <span class="font-semibold">{{ rand(5, 15) }}</span> Venues
                </div>
                <div class="bg-white/20 px-3 py-2 rounded-lg backdrop-blur-sm text-sm">
                    <span class="font-semibold">{{ rand(10, 40) }}K</span> Attendees
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Event for this Category -->
    @if($events->count() > 0)
        <div class="container mx-auto px-4 -mt-10 relative z-10 mb-10">
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-1/3">
                        <div class="relative h-64 rounded-xl overflow-hidden">
                            @if(isset($category->image) && $category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Featured Event" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute top-0 left-0 mt-4 ml-4">
                                <span class="px-3 py-1 bg-gradient-primary text-white text-xs font-bold rounded-full shadow-lg">Featured</span>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-2/3">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-2xl font-bold text-gradient">{{ $category->name }} Highlight Event</h3>
                            <div class="px-4 py-1 bg-primary-50 text-primary-600 rounded-full text-sm font-medium">Upcoming</div>
                        </div>
                        <div class="flex items-center text-sm text-slate-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ now()->addDays(rand(10, 60))->format('d F Y') }} • 19:30 WIB</span>
                            <span class="mx-2">|</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            <span>JIExpo Kemayoran, Jakarta</span>
                        </div>
                        <p class="text-slate-600 mb-4">
                            Experience the ultimate {{ $category->name }} extravaganza with world-class artists and cutting-edge production. An immersive musical journey that will redefine your concert experience.
                        </p>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mt-4">
                            <div class="mb-4 sm:mb-0">
                                <span class="block text-sm text-slate-500 mb-1">Ticket Price</span>
                                <span class="text-2xl font-bold text-gradient">Rp {{ number_format(rand(500, 2500) * 1000, 0, ',', '.') }}</span>
                            </div>
                            <a href="#" class="btn-gradient text-white px-6 py-3 rounded-lg hover:shadow-lg transition-all inline-flex items-center justify-center">
                                <span>Get Tickets</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Events Listing -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gradient">{{ $events->total() }} {{ $category->name }} Konser</h2>
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
                            <span class="px-3 py-1 bg-gradient-primary text-white text-xs font-bold rounded-full shadow-lg">{{ $category->name }}</span>
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
                            {{ $event->location }}
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
                <h3 class="text-2xl font-bold text-slate-800 mb-3">Tidak ada konser {{ $category->name }} saat ini</h3>
                <p class="text-slate-600 mb-6 max-w-md mx-auto">Kami belum memiliki konser untuk kategori ini. Silakan cek kategori lain atau kembali lagi nanti.</p>
                <a href="{{ route('events') }}" class="btn-gradient text-white px-6 py-3 rounded-lg hover:shadow-lg transition-all inline-flex items-center justify-center">
                    <span>Lihat Semua Konser</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        @endif
        
        <!-- Related Artists Section -->
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gradient mb-8">Top {{ $category->name }} Artists</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <!-- Artist 1 -->
                <div class="text-center">
                    <div class="w-full aspect-square rounded-full overflow-hidden mb-4 border-2 border-white shadow-md mx-auto max-w-[120px]">
                        <img src="https://randomuser.me/api/portraits/men/{{ rand(1, 99) }}.jpg" alt="Artist 1" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-slate-800">Artist Name</h3>
                    <p class="text-sm text-slate-500">{{ rand(5, 25) }} Events</p>
                </div>
                
                <!-- Artist 2 -->
                <div class="text-center">
                    <div class="w-full aspect-square rounded-full overflow-hidden mb-4 border-2 border-white shadow-md mx-auto max-w-[120px]">
                        <img src="https://randomuser.me/api/portraits/women/{{ rand(1, 99) }}.jpg" alt="Artist 2" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-slate-800">Artist Name</h3>
                    <p class="text-sm text-slate-500">{{ rand(5, 25) }} Events</p>
                </div>
                
                <!-- Artist 3 -->
                <div class="text-center">
                    <div class="w-full aspect-square rounded-full overflow-hidden mb-4 border-2 border-white shadow-md mx-auto max-w-[120px]">
                        <img src="https://randomuser.me/api/portraits/men/{{ rand(1, 99) }}.jpg" alt="Artist 3" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-slate-800">Artist Name</h3>
                    <p class="text-sm text-slate-500">{{ rand(5, 25) }} Events</p>
                </div>
                
                <!-- Artist 4 -->
                <div class="text-center">
                    <div class="w-full aspect-square rounded-full overflow-hidden mb-4 border-2 border-white shadow-md mx-auto max-w-[120px]">
                        <img src="https://randomuser.me/api/portraits/women/{{ rand(1, 99) }}.jpg" alt="Artist 4" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-slate-800">Artist Name</h3>
                    <p class="text-sm text-slate-500">{{ rand(5, 25) }} Events</p>
                </div>
                
                <!-- Artist 5 -->
                <div class="text-center">
                    <div class="w-full aspect-square rounded-full overflow-hidden mb-4 border-2 border-white shadow-md mx-auto max-w-[120px]">
                        <img src="https://randomuser.me/api/portraits/men/{{ rand(1, 99) }}.jpg" alt="Artist 5" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-slate-800">Artist Name</h3>
                    <p class="text-sm text-slate-500">{{ rand(5, 25) }} Events</p>
                </div>
                
                <!-- Artist 6 -->
                <div class="text-center">
                    <div class="w-full aspect-square rounded-full overflow-hidden mb-4 border-2 border-white shadow-md mx-auto max-w-[120px]">
                        <img src="https://randomuser.me/api/portraits/women/{{ rand(1, 99) }}.jpg" alt="Artist 6" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-slate-800">Artist Name</h3>
                    <p class="text-sm text-slate-500">{{ rand(5, 25) }} Events</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 