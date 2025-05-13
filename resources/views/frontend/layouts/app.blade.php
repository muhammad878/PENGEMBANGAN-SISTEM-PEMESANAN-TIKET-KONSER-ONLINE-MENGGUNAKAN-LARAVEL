<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Carbon;
    @endphp
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KonserKUY') }} - @yield('title', 'Platform Ticketing Konser #1 di Indonesia')</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Additional Styles -->
    <style>
        :root {
            --primary-100: #eff6ff;
            --primary-200: #dbeafe;
            --primary-300: #bfdbfe;
            --primary-400: #93c5fd;
            --primary-500: #60a5fa;
            --primary-600: #3b82f6;
            --primary-700: #2563eb;
            --primary-800: #1d4ed8;
            --primary-900: #1e40af;
            --primary-950: #1e3a8a;
            
            --accent-100: #fdf4ff;
            --accent-200: #fae8ff;
            --accent-300: #f5d0fe;
            --accent-400: #f0abfc;
            --accent-500: #e879f9;
            --accent-600: #d946ef;
            --accent-700: #c026d3;
            --accent-800: #a21caf;
            --accent-900: #86198f;
            --accent-950: #701a75;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--accent-600) 100%);
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--accent-600) 100%);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, var(--primary-700) 0%, var(--accent-700) 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.3);
        }
        
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.1);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--accent-600) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }
        
        /* Animation classes */
        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }
            25% {
                transform: translateY(-10px) rotate(2deg);
            }
            50% {
                transform: translateY(0px) rotate(0deg);
            }
            75% {
                transform: translateY(10px) rotate(-2deg);
            }
            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 20px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animation-delay-300 {
            animation-delay: 300ms;
        }
        .animation-delay-500 {
            animation-delay: 500ms;
        }
        .animation-delay-700 {
            animation-delay: 700ms;
        }
        
        .animate-pulse {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen flex flex-col">
    <!-- Header -->
    @include('frontend.includes.header')
    
    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('frontend.includes.footer')
    
    <!-- Toast Notifications -->
    @if(session('success') || session('error') || session('warning'))
    <div id="toast-notification" class="fixed bottom-4 right-4 z-50 max-w-sm transition-opacity duration-300 opacity-0">
        @if(session('success'))
        <div class="bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif
        
        @if(session('error'))
        <div class="bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif
        
        @if(session('warning'))
        <div class="bg-yellow-500 text-white px-6 py-4 rounded-lg shadow-lg">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
        @endif
    </div>
    
    <script>
        // Show toast notification
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast-notification');
            if (toast) {
                setTimeout(() => {
                    toast.classList.replace('opacity-0', 'opacity-100');
                }, 300);
                
                setTimeout(() => {
                    toast.classList.replace('opacity-100', 'opacity-0');
                }, 5000);
            }
        });
    </script>
    @endif
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html> 