<!DOCTYPE html>
@php
    use Illuminate\Support\Facades\Auth;
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div class="flex">
                <!-- Sidebar -->
                <div class="w-64 bg-gray-800 text-white min-h-screen p-4">
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold">KonserKUY Admin</h1>
                    </div>
                    
                    <nav>
                        <ul>
                            <li class="mb-2">
                                <a href="{{ route('admin.dashboard') }}" class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                                    <span class="mr-2">📊</span> Dashboard
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('admin.users.index') }}" class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                                    <span class="mr-2">👥</span> Manajemen User
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('admin.events.validation') }}" class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.events.*') ? 'bg-gray-700' : '' }}">
                                    <span class="mr-2">🎭</span> Validasi Event
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('admin.reports.transactions') }}" class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-700' : '' }}">
                                    <span class="mr-2">📝</span> Laporan Transaksi
                                </a>
                            </li>
                            <li class="pt-4 mt-4 border-t border-gray-700">
                                <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-gray-700">
                                    <span class="mr-2">🏠</span> Kembali ke Website
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <!-- Top Header -->
                    <header class="bg-white shadow">
                        <div class="flex justify-between items-center px-6 py-4">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                @yield('header')
                            </h2>
                            <div class="flex items-center">
                                <span class="text-sm text-gray-600 mr-4">{{ Auth::user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main class="p-6">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html> 