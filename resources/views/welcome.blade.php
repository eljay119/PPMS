<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PPMS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            
        @endif
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 relative">
            <img id="background" class="absolute top-0 left-0 w-full h-full object-cover" src="{{ asset('img/background.jpg') }}" alt="Background Image" />
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl text-center mt-12">
                    <!-- Logo -->
                    <img src="{{ asset('img/bisu.png') }}" alt="Logo" class="mx-auto w-24 mb-4">
                    
                    <!-- Title -->
                    <h1 class="text-4xl font-bold text-blue-700">Bohol Island State University</h1>
                    <h2 class="text-2xl font-semibold text-blue-700">Candijay Campus</h2>
                    <p class="text-lg text-blue-600">Procurement Project Monitoring System</p>
                </div>
                
                <!-- Navigation Links -->
                @if (Route::has('login'))
                    <nav class="mt-6 flex space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary px-4 py-2 transition-transform transform hover:scale-105">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 transition-transform transform hover:scale-105">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-primary px-4 py-2 transition-transform transform hover:scale-105">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </body>
</html>
