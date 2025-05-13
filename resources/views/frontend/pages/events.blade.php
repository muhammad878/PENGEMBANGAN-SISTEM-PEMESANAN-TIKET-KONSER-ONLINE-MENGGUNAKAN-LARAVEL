@extends('frontend.layouts.app')

@section('title', 'Konser - KonserKUY')

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
            <h1 class="text-4xl md:text-5xl font-bold mb-2 animate-fade-in-up">Semua Konser</h1>
            <p class="text-xl opacity-90 animate-fade-in-up">Temukan konser favorit Anda dari berbagai kategori dan lokasi</p>
        </div>
    </div>

    <!-- Events Listing -->
    <div class="container mx-auto px-4 py-12">
        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-10 hover-lift">
            <h2 class="text-2xl font-bold text-gradient mb-6">Filter Konser</h2>
            <form action="{{ route('events') }}" method="get" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                    <select name="category" id="category" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-slate-700 mb-2">Lokasi</label>
                    <select name="location" id="location" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 transition-all">
                        <option value="">Semua Lokasi</option>
                        @foreach($locations as $location)
                        <option value="{{ $location->location }}" {{ request('location') == $location->location ? 'selected' : '' }}>{{ $location->location }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="date" class="block text-sm font-medium text-slate-700 mb-2">Tanggal</label>
                    <select name="date" id="date" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 transition-all">
                        <option value="">Semua Tanggal</option>
                        <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="next-month" {{ request('date') == 'next-month' ? 'selected' : '' }}>Bulan Depan</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full btn-gradient text-white px-6 py-3 rounded-lg hover:shadow-lg transition-all flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Results -->
        <div>
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gradient">{{ $events->total() }} Konser Ditemukan</h2>
                <div class="text-sm text-slate-600 bg-white rounded-full px-4 py-2 shadow-md">
                    Halaman {{ $events->currentPage() }} dari {{ $events->lastPage() }}
                </div>
            </div>

            <!-- Quick Category Filters -->
            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('events') }}" class="px-4 py-2 {{ !request('category') ? 'bg-gradient-primary text-white' : 'bg-white text-primary-600' }} rounded-full text-sm font-medium hover:shadow-lg transition-all">
                    Semua
                </a>
                @foreach($categories->take(7) as $category)
                <a href="{{ route('events', ['category' => $category->slug]) }}" class="px-4 py-2 {{ request('category') == $category->slug ? 'bg-gradient-primary text-white' : 'bg-white text-primary-600' }} rounded-full text-sm font-medium hover:bg-primary-50 transition-all shadow-sm">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @if($events->count() > 0)
                    @foreach($events as $event)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-xl hover-lift transition-all duration-300">
                        <div class="relative">
                            @php
                                // Cek jika poster_path ada
                                if ($event->poster_path) {
                                    // Gunakan path langsung karena sudah di direktori public
                                    $imagePath = $event->poster_path;
                                    // Log info untuk debugging
                                    \Illuminate\Support\Facades\Log::info('Event poster display attempt: ' . $imagePath);
                                } else {
                                    // Jika tidak ada poster, gunakan gambar default
                                    $imagePath = 'images/default-event.jpg';
                                }
                            @endphp
                            <img src="{{ asset($imagePath) }}" 
                                alt="{{ $event->title }}" class="w-full h-52 object-cover"
                                onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}'; console.log('Image failed to load, using default')">
                            <div class="absolute top-0 left-0 mt-4 ml-4">
                                <span class="px-3 py-1 bg-gradient-primary text-white text-xs font-bold rounded-full shadow-lg">
                                    @php
                                        $categoryName = 'Uncategorized';
                                        if ($event->category_id) {
                                            $category = App\Models\Category::find($event->category_id);
                                            if ($category) {
                                                $categoryName = $category->name;
                                            }
                                        }
                                        echo $categoryName;
                                    @endphp
                                </span>
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
                @else
                    <div class="col-span-4 text-center py-12">
                        <div class="bg-white p-8 rounded-2xl shadow-md mx-auto max-w-lg">
                            <div class="h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Tidak ada konser ditemukan</h3>
                            <p class="text-gray-500 mb-6">Coba ubah filter pencarian Anda untuk menemukan konser yang sesuai.</p>
                            <a href="{{ route('events') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-primary text-white font-medium rounded-full transition-all hover:shadow-lg">
                                Lihat Semua Konser
                            </a>
                        </div>
                    </div>
                @endif
                </div>

                <!-- Pagination -->
            <div class="mt-12">
                {{ $events->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <!-- Event Highlights Section -->
    <div class="container mx-auto px-4 py-16 border-t border-gray-200">
        <h2 class="text-3xl font-bold text-gradient mb-10 text-center">Event Highlights</h2>
        <div class="bg-white rounded-2xl overflow-hidden shadow-xl mb-16">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-2/5">
                    <div class="h-full relative">
                        <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1074&q=80" alt="Blackpink World Tour" class="w-full h-full object-cover">
                        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-black/60 to-transparent md:bg-gradient-to-b flex items-center md:hidden">
                            <h3 class="text-white text-3xl font-bold px-6">Blackpink<br>World Tour</h3>
                        </div>
                    </div>
                </div>
                <div class="md:w-3/5 p-8 md:p-12">
                    <div class="flex items-center mb-4">
                        <span class="px-3 py-1 bg-primary-100 text-primary-600 rounded-full text-sm font-medium">K-Pop</span>
                        <span class="ml-3 px-3 py-1 bg-rose-100 text-rose-600 rounded-full text-sm font-medium">Trending</span>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-800 mb-4 hidden md:block">Blackpink World Tour - Born Pink</h3>
                    <p class="text-slate-600 mb-6">BLACKPINK membawa tur dunia mereka "Born Pink" ke Indonesia, menampilkan lagu-lagu hit seperti "Pink Venom," "Shut Down," dan banyak lagi. Konser ini akan menjadi salah satu konser K-pop terbesar tahun ini dengan stage production spektakuler dan penampilan yang energik.</p>
                    
                    <div class="flex flex-col sm:flex-row gap-8 mb-6">
                        <div>
                            <h4 class="text-sm font-semibold text-slate-500 mb-1">Tanggal & Waktu</h4>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-slate-800">11 Mar 2024 • 19:00 WIB</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-500 mb-1">Lokasi</h4>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-slate-800">Gelora Bung Karno, Jakarta</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div>
                            <span class="text-sm text-slate-500 mb-1 block">Mulai dari</span>
                            <span class="text-3xl font-bold text-gradient">Rp 1.800.000</span>
                        </div>
                        <a href="#" class="btn-gradient text-white px-8 py-3 rounded-lg hover:shadow-lg transition-all inline-flex items-center">
                            <span>Get Tickets</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommended Events -->
    <div class="container mx-auto px-4 py-16 border-t border-gray-200">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gradient">Recommended For You</h2>
            <a href="#" class="inline-flex items-center px-4 py-2 text-primary-600 font-medium hover:text-primary-800 transition-colors">
                <span>View All</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Recommended Event 1 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl hover-lift transition-all duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1429962714451-bb934ecdc4ec?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop" alt="Festival" class="w-full h-48 object-cover">
                    <div class="absolute top-0 right-0 mt-4 mr-4">
                        <div class="bg-amber-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">HOT EVENT</div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold text-slate-800 mb-1">Festival Dangdut Koplo 2024</h3>
                        <span class="px-2 py-1 bg-primary-50 text-primary-600 rounded-full text-xs font-medium">Koplo</span>
                    </div>
                    <div class="flex items-center text-sm text-slate-600 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <span>3-5 Mar 2024</span>
                    </div>
                    <div class="flex items-center text-sm text-slate-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span>JIExpo Kemayoran, Jakarta</span>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="font-bold text-gradient text-lg">Rp 1.350.000</span>
                        <a href="#" class="px-4 py-2 bg-primary-100 text-primary-600 rounded-lg font-medium hover:bg-primary-200 transition-colors">Detail</a>
                    </div>
                </div>
            </div>
            
            <!-- Recommended Event 2 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl hover-lift transition-all duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1493676304819-0d7a8d026dcf?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop" alt="Festival" class="w-full h-48 object-cover">
                    <div class="absolute top-0 right-0 mt-4 mr-4">
                        <div class="bg-primary-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">SELLING FAST</div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold text-slate-800 mb-1">Synchronize Festival</h3>
                        <span class="px-2 py-1 bg-primary-50 text-primary-600 rounded-full text-xs font-medium">Indie</span>
                    </div>
                    <div class="flex items-center text-sm text-slate-600 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <span>6-8 Oct 2023</span>
                    </div>
                    <div class="flex items-center text-sm text-slate-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span>Gambir Expo, Jakarta</span>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="font-bold text-gradient text-lg">Rp 950.000</span>
                        <a href="#" class="px-4 py-2 bg-primary-100 text-primary-600 rounded-lg font-medium hover:bg-primary-200 transition-colors">Detail</a>
                    </div>
                </div>
            </div>
            
            <!-- Recommended Event 3 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl hover-lift transition-all duration-300">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1459749411175-04bf5292ceea?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop" alt="Festival" class="w-full h-48 object-cover">
                    <div class="absolute top-0 right-0 mt-4 mr-4">
                        <div class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">NEW</div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold text-slate-800 mb-1">DWP 2023</h3>
                        <span class="px-2 py-1 bg-primary-50 text-primary-600 rounded-full text-xs font-medium">Koplo</span>
                    </div>
                    <div class="flex items-center text-sm text-slate-600 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <span>15-17 Dec 2023</span>
                    </div>
                    <div class="flex items-center text-sm text-slate-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span>JIEXPO Kemayoran, Jakarta</span>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="font-bold text-gradient text-lg">Rp 1.450.000</span>
                        <a href="#" class="px-4 py-2 bg-primary-100 text-primary-600 rounded-lg font-medium hover:bg-primary-200 transition-colors">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Promo Section -->
    <div class="container mx-auto px-4 py-16 border-t border-gray-200">
        <h2 class="text-3xl font-bold text-gradient mb-8">Special Offers</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Promo 1 -->
            <div class="bg-gradient-to-r from-primary-500 to-purple-600 rounded-2xl text-white p-6 hover-lift">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold mb-2">Early Bird</h3>
                        <p class="opacity-90 mb-4">20% off for early purchases</p>
                    </div>
                    <span class="text-3xl font-bold">20%</span>
                </div>
                <p class="text-sm opacity-90 mb-4">Valid for selected events until 30 Sep 2023</p>
                <div class="mt-2">
                    <div class="flex items-center justify-between px-3 py-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <span class="text-sm font-semibold">EARLYBIRD20</span>
                        <button class="text-xs bg-white text-primary-600 px-2 py-1 rounded">Copy</button>
                    </div>
                </div>
            </div>
            
            <!-- Promo 2 -->
            <div class="bg-gradient-to-r from-rose-500 to-orange-500 rounded-2xl text-white p-6 hover-lift">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold mb-2">Flash Sale</h3>
                        <p class="opacity-90 mb-4">Buy 1 Get 1 for selected shows</p>
                    </div>
                    <span class="text-xl font-bold">BUY 1<br>GET 1</span>
                </div>
                <p class="text-sm opacity-90 mb-4">Limited time offer until 15 Oct 2023</p>
                <div class="mt-2">
                    <div class="flex items-center justify-between px-3 py-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <span class="text-sm font-semibold">FLASHBOGO</span>
                        <button class="text-xs bg-white text-rose-600 px-2 py-1 rounded">Copy</button>
                    </div>
                </div>
            </div>
            
            <!-- Promo 3 -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl text-white p-6 hover-lift">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold mb-2">Student</h3>
                        <p class="opacity-90 mb-4">15% discount for students</p>
                    </div>
                    <span class="text-3xl font-bold">15%</span>
                </div>
                <p class="text-sm opacity-90 mb-4">Valid with student ID on selected concerts</p>
                <div class="mt-2">
                    <div class="flex items-center justify-between px-3 py-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <span class="text-sm font-semibold">STUDENT15</span>
                        <button class="text-xs bg-white text-emerald-600 px-2 py-1 rounded">Copy</button>
                    </div>
                </div>
            </div>
            
            <!-- Promo 4 -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl text-white p-6 hover-lift">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold mb-2">Group</h3>
                        <p class="opacity-90 mb-4">10% off for group purchases</p>
                    </div>
                    <span class="text-3xl font-bold">10%</span>
                </div>
                <p class="text-sm opacity-90 mb-4">For purchases of 4+ tickets in one transaction</p>
                <div class="mt-2">
                    <div class="flex items-center justify-between px-3 py-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <span class="text-sm font-semibold">GROUP10</span>
                        <button class="text-xs bg-white text-blue-600 px-2 py-1 rounded">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Venues Section -->
    <div class="container mx-auto px-4 py-16 border-t border-gray-200">
        <h2 class="text-3xl font-bold text-gradient mb-10">Popular Venues</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Venue 1 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl hover-lift transition-all group">
                <div class="relative h-48">
                    <img src="https://images.unsplash.com/photo-1574691250077-03a929faece5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Gelora Bung Karno" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-1">Gelora Bung Karno</h3>
                            <div class="flex items-center text-white/80 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                Jakarta
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-slate-600">
                            <div class="flex items-center mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 000 4zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                                <span>Kapasitas: 80,000</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span>8 event bulan ini</span>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-primary-100 text-primary-600 rounded-full text-xs font-medium">Stadium</span>
                    </div>
                    <a href="{{ route('venues.show', 'gelora-bung-karno') }}" class="btn-gradient text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all inline-flex items-center justify-center w-full">
                        <span>Lihat Konser</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Venue 2 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl hover-lift transition-all group">
                <div class="relative h-48">
                    <img src="https://images.unsplash.com/photo-1587162146766-e06b1189b907?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="JIExpo Kemayoran" class="w-full h-full object-cover">
                    <div class="absolute top-0 right-0 mt-4 mr-4">
                        <div class="bg-primary-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">SELLING FAST</div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-slate-600">
                            <div class="flex items-center mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 000 4zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                                <span>Kapasitas: 35,000</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span>12 event bulan ini</span>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-primary-100 text-primary-600 rounded-full text-xs font-medium">Exhibition</span>
                    </div>
                    <a href="{{ route('venues.show', 'jiexpo-kemayoran') }}" class="btn-gradient text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all inline-flex items-center justify-center w-full">
                        <span>Lihat Konser</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Venue 3 -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl hover-lift transition-all group">
                <div class="relative h-48">
                    <img src="https://images.unsplash.com/photo-1560193788-6518e5224b9d?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt="Taman Ismail Marzuki" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-1">Taman Ismail Marzuki</h3>
                            <div class="flex items-center text-white/80 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                Jakarta
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-slate-600">
                            <div class="flex items-center mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 000 4zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                                <span>Kapasitas: 5,000</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary-600 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span>5 event bulan ini</span>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-primary-100 text-primary-600 rounded-full text-xs font-medium">Theater</span>
                    </div>
                    <a href="{{ route('venues.show', 'taman-ismail-marzuki') }}" class="btn-gradient text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all inline-flex items-center justify-center w-full">
                        <span>Lihat Konser</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 