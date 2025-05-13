<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'KonserKUY - Platform Tiket Konser #1 di Indonesia')</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
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
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            background-attachment: fixed;
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
        }
        
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.2s ease;
        }
        
        .card:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased text-slate-800">
    
    <!-- Header -->
    @include('frontend.includes.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('frontend.includes.footer')
    
    <!-- Additional Scripts -->
    @stack('scripts')
    
</body>
</html> 