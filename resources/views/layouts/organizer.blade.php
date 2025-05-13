<!DOCTYPE html>
@php
    use Illuminate\Support\Facades\Auth;
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Event Organizer</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        
        <style>
            body {
                font-family: 'Outfit', 'Figtree', sans-serif;
            }
            .sidebar-gradient {
                background: linear-gradient(180deg, #0369a1 0%, #075985 100%);
            }
            .nav-link {
                transition: all 0.2s ease;
                border-left: 3px solid transparent;
            }
            .nav-link:hover {
                background-color: rgba(255, 255, 255, 0.1);
                border-left-color: #38bdf8;
            }
            .nav-link.active {
                background-color: rgba(56, 189, 248, 0.15);
                border-left-color: #38bdf8;
            }
            .card-stats {
                transition: all 0.2s ease;
            }
            .card-stats:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.05);
            }
            .alert {
                border-radius: 0.5rem;
                padding: 0.75rem 1rem;
                margin-bottom: 1rem;
                border-width: 1px;
                border-left-width: 4px;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-50">
            <div class="flex">
                <!-- Sidebar -->
                <div class="w-64 sidebar-gradient text-white min-h-screen shadow-lg">
                    <div class="p-6 border-b border-sky-800/50">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-300 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <h1 class="text-2xl font-bold tracking-tight text-white">KonserKUY</h1>
                        </div>
                        <p class="text-xs text-sky-200 mt-2">Organizer Dashboard</p>
                    </div>
                    
                    <nav class="mt-6 px-3">
                        <p class="text-xs font-medium text-sky-200 uppercase tracking-wider mb-3 px-3">Menu Utama</p>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('organizer.dashboard') }}" class="nav-link flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('organizer.dashboard') ? 'active bg-sky-800/20 text-sky-300' : 'text-slate-300 hover:text-white' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('organizer.events.index') }}" class="nav-link flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('organizer.events.*') ? 'active bg-sky-800/20 text-sky-300' : 'text-slate-300 hover:text-white' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Kelola Event
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('organizer.orders') }}" class="nav-link flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('organizer.orders*') ? 'active bg-sky-800/20 text-sky-300' : 'text-slate-300 hover:text-white' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Daftar Pesanan
                                </a>
                            </li>
                        </ul>
                        
                        <hr class="my-6 border-t border-sky-800/50" />
                        
                        <ul>
                            <li>
                                <a href="{{ route('dashboard') }}" class="nav-link flex items-center px-3 py-2 rounded-lg text-sm text-slate-300 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Kembali ke Website
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <!-- Top Header -->
                    <header class="bg-white shadow-sm">
                        <div class="flex justify-between items-center px-6 py-4">
                            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                                @yield('header')
                            </h2>
                            <div class="flex items-center">
                                <div class="mr-4 relative group">
                                    <button class="flex items-center text-sm text-slate-600 hover:text-slate-900 focus:outline-none">
                                        <span class="mr-1">{{ Auth::user()->name }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-sm flex items-center text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main class="p-6">
                        @if (session('success'))
                            <div class="alert bg-green-50 border-green-500 text-green-700 mb-6">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif
                        
                        @if (session('error'))
                            <div class="alert bg-red-50 border-red-500 text-red-700 mb-6">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif
                        
                        @if (session('info'))
                            <div class="alert bg-blue-50 border-blue-500 text-blue-700 mb-6">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ session('info') }}
                                </div>
                            </div>
                        @endif
                        
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html> 