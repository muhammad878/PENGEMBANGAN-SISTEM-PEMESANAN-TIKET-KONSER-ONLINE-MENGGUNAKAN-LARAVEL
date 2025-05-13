@php
    use Illuminate\Support\Facades\Auth;
@endphp

<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-gradient text-2xl font-bold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-accent-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.665 8.717a1 1 0 0 1 0-1.498l3-2.5a1 1 0 0 1 1.67.744v5.074a1 1 0 0 1-1.67.744l-3-2.5zM6.5 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 0a3 3 0 0 0 0 6h.967c.176 0 .35-.046.504-.134a4.5 4.5 0 0 0 1.55-1.417.5.5 0 0 1 .67-.112l2.451 1.5c.72.44.72 1.5 0 1.94l-7.08 4.33A.5.5 0 0 1 5 19V5a.5.5 0 0 1 .73-.442L10 7.401A3.002 3.002 0 0 0 6.5 9z" clip-rule="evenodd" />
                    </svg>
                    KonserKUY
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 text-sm">Beranda</a>
                <a href="{{ route('events') }}" class="text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 text-sm">Konser</a>
                <a href="{{ route('categories') }}" class="text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 text-sm">Kategori</a>
                <a href="{{ route('venues') }}" class="text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 text-sm">Venue</a>
                <a href="{{ route('about') }}" class="text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 text-sm">Tentang Kami</a>
            </nav>

            <!-- Authentication Links -->
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-primary-600 font-medium transition-colors duration-200 text-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-gradient text-white px-5 py-2 rounded-lg hover:shadow-lg text-sm">Daftar</a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-slate-600 hover:text-primary-600 focus:outline-none transition-colors duration-200">
                            <div class="w-8 h-8 rounded-full bg-gradient-primary flex items-center justify-center text-white mr-2 text-xs uppercase font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="mr-1 text-sm">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-2 z-50 border border-slate-100">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                    </svg>
                                    Admin Dashboard
                                </a>
                            @elseif(Auth::user()->role === 'eo')
                                <a href="{{ route('organizer.dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    Organizer Dashboard
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    Dashboard
                                </a>
                            @endif
                            
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                Profil
                            </a>
                            <a href="{{ route('payment.history') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                Tiket & Pembayaran
                            </a>
                            
                            <div class="border-t border-slate-100 my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-slate-50 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414l-5.707-5.707A1 1 0 009.586 2H3zm0 1h6v4a1 1 0 001 1h4v7H3V4z" clip-rule="evenodd" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile Navigation Toggle -->
            <div class="md:hidden flex items-center">
                <button class="mobile-menu-button" x-data @click="$dispatch('toggle-mobile-menu')">
                    <svg class="h-6 w-6 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div class="mobile-menu hidden md:hidden mt-4 pb-2" x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open">
            <a href="{{ route('home') }}" class="block py-2 text-slate-600 hover:text-primary-600 font-medium">Beranda</a>
            <a href="{{ route('events') }}" class="block py-2 text-slate-600 hover:text-primary-600 font-medium">Konser</a>
            <a href="{{ route('categories') }}" class="block py-2 text-slate-600 hover:text-primary-600 font-medium">Kategori</a>
            <a href="{{ route('venues') }}" class="block py-2 text-slate-600 hover:text-primary-600 font-medium">Venue</a>
            <a href="{{ route('about') }}" class="block py-2 text-slate-600 hover:text-primary-600 font-medium">Tentang Kami</a>
            
            @guest
                <div class="mt-4 flex space-x-4">
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-primary-600 font-medium">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-gradient text-white px-4 py-2 rounded-lg">Daftar</a>
                </div>
            @else
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center mb-3 px-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-primary flex items-center justify-center text-white mr-2 text-xs uppercase font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="text-slate-800 font-medium">{{ Auth::user()->name }}</span>
                    </div>
                    
                    <a href="{{ route('profile.show') }}" class="block py-2 text-slate-600 hover:text-primary-600 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Profil
                    </a>
                    <a href="{{ route('payment.history') }}" class="block py-2 text-slate-600 hover:text-primary-600 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Tiket & Pembayaran
                    </a>
                    
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 text-slate-600 hover:text-primary-600 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                            Admin Dashboard
                        </a>
                    @elseif(Auth::user()->role === 'eo')
                        <a href="{{ route('organizer.dashboard') }}" class="block py-2 text-slate-600 hover:text-primary-600 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            Organizer Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="block py-2 text-slate-600 hover:text-primary-600 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            Dashboard
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="block py-2 w-full text-left text-red-600 hover:text-red-800 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414l-5.707-5.707A1 1 0 009.586 2H3zm0 1h6v4a1 1 0 001 1h4v7H3V4z" clip-rule="evenodd" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</header>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.querySelector('.mobile-menu-button');
        const menu = document.querySelector('.mobile-menu');
        
        button.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    });
</script> 