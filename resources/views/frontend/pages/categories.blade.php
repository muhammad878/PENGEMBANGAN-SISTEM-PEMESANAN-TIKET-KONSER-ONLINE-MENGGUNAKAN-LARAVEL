@extends('frontend.layouts.app')

@section('title', 'Kategori Konser - KonserKUY')

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
            <h1 class="text-4xl md:text-5xl font-bold mb-2 animate-fade-in-up">Kategori Konser</h1>
            <p class="text-xl opacity-90 animate-fade-in-up">Temukan konser berdasarkan kategori yang Anda minati</p>
        </div>
    </div>

    <!-- Categories List -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @if(isset($categories) && count($categories) > 0)
                @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="bg-white rounded-2xl p-8 shadow-xl hover-lift transition-all duration-300 group">
                    <div class="mb-6 w-16 h-16 bg-gradient-primary rounded-full flex items-center justify-center text-white shadow-lg">
                        @php
                            // Category specific icons
                            $iconMap = [
                                'K-Pop' => '<path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />',
                                'Pop' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />',
                                'Koplo' => '<path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />',
                                'Indie' => '<path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />',
                                'Classical' => '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />',
                                'Festival' => '<path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100-2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd" />',
                            ];

                            // Default icons for categories that don't have a specific icon
                            $defaultIcons = [
                                'music' => '<path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />',
                                'star' => '<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />',
                                'lightning' => '<path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />',
                                'info' => '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />',
                                'refresh' => '<path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />',
                                'play' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />',
                                'plus' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />',
                                'microphone' => '<path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100-2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd" />',
                            ];

                            // Get icon for this category
                            $icon = isset($iconMap[$category->name]) ? $iconMap[$category->name] : $defaultIcons['music'];
                        @endphp
                        
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            {!! $icon !!}
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2 group-hover:text-primary-600 transition">{{ $category->name }}</h3>
                    <p class="text-slate-600 mb-2">{{ $category->event_count }} Konser</p>
                    <div class="mt-4 inline-flex items-center text-primary-600 group-hover:text-primary-800">
                        <span class="text-sm font-medium">Lihat Konser</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
                @endforeach
            @else
                <div class="col-span-4 text-center py-12">
                    <div class="bg-white p-8 rounded-2xl shadow-md mx-auto max-w-lg">
                        <div class="h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada kategori</h3>
                        <p class="text-gray-500 mb-6">Kembali lagi nanti untuk melihat kategori konser.</p>
                        <a href="{{ route('events') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-primary text-white font-medium rounded-full transition-all hover:shadow-lg">
                            Lihat Semua Konser
                        </a>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Statistics Section -->
        @if(isset($categories) && count($categories) > 0)
        <div class="mt-16 bg-white rounded-2xl shadow-xl p-8 md:p-10 hover-lift">
            <h2 class="text-3xl font-bold text-gradient mb-8 text-center">Statistik Kategori Konser</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div class="p-4">
                    <div class="text-4xl font-bold text-gradient mb-2">{{ count($categories) }}</div>
                    <p class="text-slate-600">Kategori Konser</p>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold text-gradient mb-2">
                        @php
                            $totalEvents = $categories->sum('event_count');
                            echo $totalEvents;
                        @endphp
                    </div>
                    <p class="text-slate-600">Total Konser</p>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold text-gradient mb-2">
                        @php
                            $maxEvents = $categories->max('event_count');
                            echo $maxEvents;
                        @endphp
                    </div>
                    <p class="text-slate-600">Konser Terbanyak</p>
                </div>
                <div class="p-4">
                    <div class="text-4xl font-bold text-gradient mb-2">
                        @php
                            // Get count of upcoming events - we'll use a placeholder here
                            echo rand(5, 30);
                        @endphp
                    </div>
                    <p class="text-slate-600">Upcoming Konser</p>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Featured Categories (top 2 by event count) -->
        @if(isset($categories) && count($categories) > 1)
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gradient mb-8">Kategori Terpopuler</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @php
                    $topCategories = $categories->sortByDesc('event_count')->take(2);
                @endphp
                
                @foreach($topCategories as $category)
                <div class="bg-white rounded-2xl overflow-hidden shadow-xl group hover-lift">
                    <div class="h-40 bg-gradient-primary flex items-center justify-center relative overflow-hidden">
                        <!-- Decorative elements -->
                        <div class="absolute inset-0 overflow-hidden opacity-20">
                            <div class="absolute animate-float" style="top: 10%; left: 5%;">
                                <svg class="w-20 h-20 text-white opacity-30" viewBox="0 0 80 80" fill="currentColor">
                                    <circle cx="40" cy="40" r="40" />
                                </svg>
                            </div>
                            <div class="absolute animate-float animation-delay-500" style="top: 20%; right: 10%;">
                                <svg class="w-32 h-32 text-white opacity-20" viewBox="0 0 80 80" fill="currentColor">
                                    <circle cx="40" cy="40" r="40" />
                                </svg>
                            </div>
                        </div>
                        
                        <h3 class="text-4xl font-bold text-white relative z-10">{{ $category->name }}</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <span class="px-3 py-1 bg-primary-50 text-primary-600 text-sm font-medium rounded-full">{{ $category->event_count }} Konser</span>
                        </div>
                        <p class="text-slate-600 mb-4">Berbagai konser {{ $category->name }} dari artis terkenal hingga pendatang baru.</p>
                        <a href="{{ route('categories.show', $category->slug) }}" class="inline-flex items-center font-medium text-primary-600 hover:text-primary-700">
                            <span>Jelajahi Kategori</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 