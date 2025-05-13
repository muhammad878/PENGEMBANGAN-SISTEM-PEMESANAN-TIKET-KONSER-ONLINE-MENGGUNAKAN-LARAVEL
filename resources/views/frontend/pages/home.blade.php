@extends('frontend.layouts.app')

@section('title', 'Beranda - KonserKUY')

@section('content')
<div class="bg-gray-50">
    <!-- Hero Banner -->
    <div class="relative overflow-hidden bg-gradient-primary text-white">
        <!-- Background animated elements -->
        <div class="absolute inset-0 overflow-hidden opacity-20">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/4 right-1/3 w-64 h-64 bg-purple-300 opacity-20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-pink-300 opacity-20 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-4 py-20 md:py-28 relative z-10">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0 animate-fade-in-up">
                    <div class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-6 animate-pulse">
                        🎵 #RasakanEuforia 🎉
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight text-white drop-shadow-lg">Temukan Konser <span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-pink-400 font-black">Terbaik</span> di KonserKUY</h1>
                    <p class="text-lg mb-8 text-white/90 max-w-lg font-medium">Platform ticketing konser #1 di Indonesia dengan jaminan tiket asli dan proses pembelian yang mudah</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('events') }}" class="group bg-white text-red-600 px-6 py-3 rounded-full font-medium text-center hover:bg-gray-100 transition flex items-center justify-center gap-2">
                            Lihat Semua Konser
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <a href="{{ route('register') }}" class="group btn-gradient text-white px-6 py-3 rounded-full font-medium text-center transition flex items-center justify-center">
                            Daftar Sekarang
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="flex flex-wrap gap-8 mt-12 rounded-xl backdrop-blur-sm p-5 border border-white/20 bg-gradient-to-r from-primary-600/20 to-accent-600/20">
                        <div class="animate-fade-in-up" style="animation-delay: 200ms">
                            <p class="text-3xl font-bold text-white drop-shadow-lg">500+</p>
                            <p class="text-white text-sm font-medium">Konser Setiap Bulan</p>
                        </div>
                        <div class="animate-fade-in-up" style="animation-delay: 400ms">
                            <p class="text-3xl font-bold text-white drop-shadow-lg">50.000+</p>
                            <p class="text-white text-sm font-medium">Pengguna Aktif</p>
                        </div>
                        <div class="animate-fade-in-up" style="animation-delay: 600ms">
                            <p class="text-3xl font-bold text-white drop-shadow-lg">100%</p>
                            <p class="text-white text-sm font-medium">Jaminan Tiket</p>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 relative animate-fade-in-up" style="animation-delay: 300ms">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-600/30 to-accent-600/30 rounded-lg backdrop-blur-sm transform rotate-3 scale-105"></div>
                    <img src="{{ asset('images/hero-image.jpg') }}" alt="KonserKUY Hero" class="rounded-lg shadow-2xl max-w-full h-auto relative z-10 transform transition-all hover:scale-105 hover:-rotate-2 duration-500">
                    
                    <!-- Floating Elements -->
                    <div class="absolute -top-8 -left-8 bg-white p-4 rounded-xl shadow-xl animate-float z-20 transform rotate-3 border-l-4 border-primary-500 hover:scale-110 transition-transform cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Tiket Terjual</p>
                                <p class="text-sm font-bold text-gray-800">12.5K+</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-6 -right-6 bg-white p-4 rounded-xl shadow-xl animate-float animation-delay-500 z-20 transform -rotate-2 border-r-4 border-accent-500 hover:scale-110 transition-transform cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-accent-100 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Kepuasan</p>
                                <p class="text-sm font-bold text-gray-800">98%</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- New floating element -->
                    <div class="absolute top-1/2 right-1/4 transform -translate-y-1/2 bg-yellow-50 p-3 rounded-xl shadow-xl animate-pulse animation-delay-700 z-20 rotate-6 border-b-4 border-yellow-400 hover:scale-110 transition-transform cursor-pointer">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 font-medium">Waktu Respon</p>
                                <p class="text-sm font-bold text-gray-800">< 5 menit</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- New floating element -->
                    <div class="absolute top-1/4 -left-12 transform -translate-y-1/2 bg-green-50 p-3 rounded-xl shadow-xl animate-bounce animation-delay-300 z-20 rotate-12 border-t-4 border-green-400 hover:scale-110 transition-transform cursor-pointer">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 font-medium">Tiket Asli</p>
                                <p class="text-sm font-bold text-gray-800">Dijamin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Wave divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="w-full h-auto">
                <path fill="#f9fafb" fill-opacity="1" d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
            </svg>
        </div>
    </div>

    <!-- Featured Events -->
    <div class="container mx-auto px-4 py-16">
        <div class="flex justify-between items-center mb-10">
            <div>
                <span class="text-sm font-semibold text-primary-600 uppercase tracking-wider">Discover</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-1">Konser Unggulan</h2>
            </div>
            <a href="{{ route('events') }}" class="group flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium transition-all">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @if(isset($featuredEvents) && $featuredEvents->count() > 0)
                @foreach($featuredEvents as $event)
                <div class="group relative bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 hover:-rotate-1">
                    <!-- Status badge -->
                    <div class="absolute top-4 left-4 z-20">
                        @if(strtotime($event->date) < strtotime(now()))
                            <span class="px-3 py-1 bg-gray-800/70 backdrop-blur-sm text-white text-xs font-bold rounded-full">Past</span>
                        @elseif(strtotime($event->date) - strtotime(now()) < 60*60*24*7)
                            <span class="px-3 py-1 bg-accent-600/70 backdrop-blur-sm text-white text-xs font-bold rounded-full">Coming Soon</span>
                        @else
                            <span class="px-3 py-1 bg-primary-600/70 backdrop-blur-sm text-white text-xs font-bold rounded-full">Available</span>
                        @endif
                    </div>
                    
                    <!-- Save button -->
                    <button class="absolute top-4 right-4 z-20 bg-white/30 backdrop-blur-sm p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    
                    <!-- Image with overlay -->
                    <div class="relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/40 to-transparent z-10"></div>
                    <a href="{{ route('events.show', $event->slug) }}">
                        <img src="{{ $event->poster_path ? asset($event->poster_path) : asset('images/default-event.jpg') }}" 
                                alt="{{ $event->title }}" class="w-full h-56 object-cover transform transition-transform duration-500 group-hover:scale-110"
                                onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}'; console.log('Image failed to load, using default')">
                        </a>
                        <div class="absolute bottom-4 left-4 right-4 z-10">
                            <div class="flex justify-between items-center">
                                <span class="text-white text-sm font-medium flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $event->venue }}
                                </span>
                                <span class="text-white text-sm font-medium flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $event->date->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <span class="px-2.5 py-1 bg-gradient-to-r from-primary-100 to-accent-100 text-primary-700 text-xs font-medium rounded-full">{{ $event->category }}</span>
                        </div>
                        <a href="{{ route('events.show', $event->slug) }}" class="block">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-primary-600 transition">{{ $event->title }}</h3>
                        </a>
                        <p class="text-gray-600 text-sm mb-4">{{ \Illuminate\Support\Str::limit($event->description, 90) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-accent-600 text-lg">Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</span>
                            <a href="{{ route('events.show', $event->slug) }}" class="px-4 py-2 bg-primary-100 hover:bg-primary-200 text-primary-700 text-sm font-medium rounded-full transition-colors flex items-center gap-1">
                                Detail
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-span-full text-center py-12">
                    <div class="bg-white p-8 rounded-2xl shadow-md mx-auto max-w-lg">
                        <div class="h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada konser unggulan</h3>
                        <p class="text-gray-500 mb-6">Kembali lagi nanti untuk melihat konser unggulan terbaru.</p>
                        <a href="{{ route('events') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-primary text-white font-medium rounded-full transition-all hover:shadow-lg">
                            Lihat Semua Konser
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Categories -->
    <div class="relative overflow-hidden py-20">
        <!-- Background elements -->
        <div class="absolute inset-0 bg-gray-50"></div>
        <div class="absolute top-0 inset-x-0 h-40 bg-gradient-to-b from-white to-transparent"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary-100 opacity-30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-accent-100 opacity-30 rounded-full blur-3xl"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-sm font-semibold text-primary-600 uppercase tracking-wider">Explore</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-4">Temukan Kategori Favorit Anda</h2>
                <p class="text-gray-600">Jelajahi berbagai kategori konser mulai dari musik pop, koplo, indie, hingga festival musik klasik.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="bg-white rounded-2xl p-6 shadow-md text-center hover:shadow-xl transition duration-300 group relative overflow-hidden hover:-translate-y-2">
                        <!-- Decorative background elements -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-primary-100 to-accent-50 rounded-full -mr-12 -mt-12 opacity-0 group-hover:opacity-70 transition-opacity duration-500"></div>
                        
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-gradient-to-r from-primary-50 to-accent-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-gradient-primary group-hover:shadow-lg transition-all duration-300 transform group-hover:rotate-6">
                                <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm group-hover:shadow-md transition-all">
                                    <i class="text-primary-600 text-xl group-hover:text-accent-600 transition-colors"></i>
                                </div>
                            </div>
                            <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-primary-600 transition">{{ $category->name }}</h3>
                            <div class="flex items-center justify-center">
                                <span class="px-3 py-1 bg-gray-100 rounded-full text-sm text-gray-700 font-medium">{{ $category->event_count }} Konser</span>
                            </div>
                            
                            <div class="mt-6 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-4 group-hover:translate-y-0">
                                <span class="inline-flex items-center text-primary-600 text-sm font-medium">
                                    Lihat Konser
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-12">
                        <div class="bg-white p-8 rounded-2xl shadow-md mx-auto max-w-lg">
                            <div class="h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada kategori</h3>
                            <p class="text-gray-500 mb-6">Kategori konser akan segera tersedia.</p>
                            <a href="{{ route('events') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-primary text-white font-medium rounded-full transition-all hover:shadow-lg">
                                Lihat Semua Konser
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="container mx-auto px-4 py-20">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-sm font-semibold text-primary-600 uppercase tracking-wider">Simple Process</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-4">Cara Pembelian Tiket</h2>
            <p class="text-gray-600">Proses pembelian tiket yang mudah dan aman untuk konser favorit Anda.</p>
        </div>
        
        <div class="relative">
            <!-- Connecting line -->
            <div class="hidden md:block absolute top-1/2 left-0 right-0 h-1 bg-gradient-to-r from-primary-200 via-primary-400 to-accent-400 transform -translate-y-1/2 z-0"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-16 relative z-10">
                <!-- Step 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 relative group">
                    <!-- Top decorative element -->
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 bg-gradient-primary text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg shadow-lg group-hover:scale-110 transition-transform">1</div>
                    
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-primary-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-primary-600 transition-colors">Pilih Konser</h3>
                        <p class="text-gray-600">Temukan konser favorit Anda dari berbagai kategori dan lokasi di Indonesia</p>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-4 text-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('events') }}" class="inline-flex items-center text-primary-600 text-sm font-medium">
                            Lihat Konser
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 relative group">
                    <!-- Top decorative element -->
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 bg-gradient-primary text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg shadow-lg group-hover:scale-110 transition-transform">2</div>
                    
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-accent-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-accent-600 transition-colors">Pilih Tiket</h3>
                        <p class="text-gray-600">Pilih jenis tiket yang sesuai dengan kelas dan budget Anda, tersedia berbagai pilihan</p>
            </div>
            
                    <div class="border-t border-gray-100 pt-4 text-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="inline-flex items-center text-accent-600 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Pilihan Terbaik
                        </span>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 relative group">
                    <!-- Top decorative element -->
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 bg-gradient-primary text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg shadow-lg group-hover:scale-110 transition-transform">3</div>
                    
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-blue-600 transition-colors">Pembayaran</h3>
                        <p class="text-gray-600">Lakukan pembayaran dengan berbagai metode yang aman, mudah dan terpercaya</p>
            </div>
            
                    <div class="border-t border-gray-100 pt-4 mt-auto">
                        <div class="flex justify-center gap-2 items-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" class="h-6 object-contain">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Mastercard_2019_logo.svg/1920px-Mastercard_2019_logo.svg.png" alt="Mastercard" class="h-6 object-contain">
                            <img src="https://assets.gopay.co.id/logo/gopay_logo_external.png" alt="GoPay" class="h-6 object-contain">
                            <img src="https://www.ovo.id/assets/images/logo-ovo-1.svg" alt="OVO" class="h-6 object-contain">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CTA Button -->
        <div class="text-center mt-12">
            <a href="{{ route('events') }}" class="inline-flex items-center px-6 py-3 bg-gradient-primary text-white font-medium rounded-full shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                Mulai Sekarang
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="relative py-20 overflow-hidden">
        <!-- Background elements -->
        <div class="absolute inset-0 bg-gray-50"></div>
        <div class="absolute top-0 inset-x-0 h-40 bg-gradient-to-b from-white to-transparent"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary-100 opacity-30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-accent-100 opacity-30 rounded-full blur-3xl"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-sm font-semibold text-primary-600 uppercase tracking-wider">Testimonials</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-4">Apa Kata Mereka</h2>
                <p class="text-gray-600">Pengalaman pelanggan yang menggunakan platform KonserKUY untuk pembelian tiket konser.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-xl relative hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                    <!-- Quote mark -->
                    <div class="absolute top-4 right-4 text-6xl leading-none text-primary-100 group-hover:text-primary-200 transition-colors">"</div>
                    
                    <div class="relative">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="relative">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Budi Santoso" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-1 -right-1 bg-primary-500 w-5 h-5 rounded-full border-2 border-white flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        <div>
                                <h4 class="font-bold text-lg text-gray-800">Budi Santoso</h4>
                                <div class="flex items-center gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-sm">Jakarta</p>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-6">"Proses pembelian tiket sangat mudah dan cepat. Saya bisa mendapatkan tiket konser idol group favorit saya tanpa perlu antre! Harga yang ditawarkan juga sangat kompetitif."</p>
                        <div class="flex items-center gap-2 text-sm text-primary-600 font-medium">
                            <span class="px-3 py-1 bg-primary-50 rounded-full">Coldplay Concert</span>
                            <span>•</span>
                            <span>Sept 2023</span>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-xl relative hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                    <!-- Quote mark -->
                    <div class="absolute top-4 right-4 text-6xl leading-none text-primary-100 group-hover:text-primary-200 transition-colors">"</div>
                    
                    <div class="relative">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="relative">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Dewi Anggraini" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-1 -right-1 bg-primary-500 w-5 h-5 rounded-full border-2 border-white flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        <div>
                                <h4 class="font-bold text-lg text-gray-800">Dewi Anggraini</h4>
                                <div class="flex items-center gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-sm">Bandung</p>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-6">"KonserKUY selalu jadi pilihan utama saya untuk beli tiket konser. Harga bersaing dan yang pasti tiket dijamin asli. Saya juga suka dengan fitur reminder konser yang akan datang."</p>
                        <div class="flex items-center gap-2 text-sm text-primary-600 font-medium">
                            <span class="px-3 py-1 bg-primary-50 rounded-full">Festival Koplo</span>
                            <span>•</span>
                            <span>Aug 2023</span>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-xl relative hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group">
                    <!-- Quote mark -->
                    <div class="absolute top-4 right-4 text-6xl leading-none text-primary-100 group-hover:text-primary-200 transition-colors">"</div>
                    
                    <div class="relative">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="relative">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden">
                                    <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Reza Pratama" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-1 -right-1 bg-primary-500 w-5 h-5 rounded-full border-2 border-white flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        <div>
                                <h4 class="font-bold text-lg text-gray-800">Reza Pratama</h4>
                                <div class="flex items-center gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 text-sm">Surabaya</p>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-6">"Sebagai event organizer, KonserKUY sangat membantu dalam mengelola penjualan tiket konser saya. Dashboard analitik yang disediakan sangat berguna untuk melihat performa penjualan. Sangat direkomendasikan!"</p>
                        <div class="flex items-center gap-2 text-sm text-primary-600 font-medium">
                            <span class="px-3 py-1 bg-primary-50 rounded-full">Event Organizer</span>
                            <span>•</span>
                            <span>Oct 2023</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Testimonial Button -->
            <div class="text-center mt-10">
                <a href="#" class="inline-flex items-center px-5 py-2 bg-white text-primary-600 font-medium rounded-full border border-gray-200 shadow-sm hover:shadow transition-all hover:bg-primary-50">
                    Lihat Semua Testimonial
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Newsletter -->
    <div class="container mx-auto px-4 py-16">
        <div class="bg-gradient-primary rounded-3xl text-white p-10 md:p-16 relative overflow-hidden shadow-xl">
            <!-- Decorative elements -->
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-10 w-80 h-80 bg-pink-500 opacity-10 rounded-full blur-3xl"></div>
            </div>
            
            <div class="relative z-10 max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Jangan Ketinggalan Konser Terbaru</h2>
                <p class="text-xl md:text-2xl text-white/90 mb-10 max-w-2xl mx-auto">Dapatkan informasi konser terbaru dan promo menarik langsung ke email Anda</p>
                
                <form class="flex flex-col sm:flex-row max-w-lg mx-auto gap-4 mb-6 relative">
                    <input 
                        type="email" 
                        placeholder="Masukkan email Anda" 
                        class="px-6 py-4 rounded-full text-gray-800 w-full focus:outline-none focus:ring-4 focus:ring-white/30 shadow-xl transition-all placeholder-gray-400" 
                        required
                    >
                    <button 
                        type="submit" 
                        class="bg-white text-primary-600 px-8 py-4 rounded-full font-medium hover:bg-gray-100 transition-all hover:shadow-lg"
                    >
                        Berlangganan
                    </button>
            </form>
                
                <p class="text-sm text-white/70">Kami menjaga privasi Anda. Dapatkan juga diskon 10% untuk pembelian pertama.</p>
                
                <!-- Trust badges -->
                <div class="flex flex-wrap justify-center gap-4 mt-8">
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">100% Aman</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                        </svg>
                        <span class="text-sm font-medium">Info Terupdate</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">Privasi Terjamin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 