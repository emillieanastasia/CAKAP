<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CAKAP</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('head')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#013C58',       
                        teal: '#00537A',       
                        sky: '#A8E8F9',        
                        gold: '#F5A201',       
                        lightgold: '#FFD35B',  
                        pale: '#FFBA42',       
                    }
                }
            }
        }
    </script>

    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-navy font-sans text-white" x-data="{ openSidebar: false }">

{{-- NAVBAR --}}
<nav class="bg-teal border-b border-sky/10 shadow-lg px-4 py-3 flex justify-between items-center sticky top-0 z-50">
    @php
        $userRole = Auth::check() ? Auth::user()->role:null;
        $showAdminSidebar = $userRole ==='admin';
    @endphp     

    {{-- Hamburger button --}}
    @if ($showAdminSidebar)
    <button 
        @click="openSidebar = !openSidebar"
        class="md:hidden text-sky hover:text-white focus:outline-none transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
        </svg>
    </button>
    @endif
    
    <div>
        <a href="/" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 object-contain">
            <span class="font-bold text-xl text-white tracking-wide">BIMBEL <span class="text-gold">CAKAP</span></span>
        </a>
    </div>

    {{-- SLOT BARU UNTUK HEADER CONTENT --}}
    <div class="hidden sm:block">
        @yield('header_content')
    </div>

    <div class="flex items-center gap-4">
        <div class="text-right hidden sm:block">
            <span class="block text-sm font-bold text-white">{{ Auth::user()->name ?? 'Admin' }}</span>
            <span class="block text-xs text-sky">{{ ucfirst($userRole ?? 'User') }}</span>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="bg-red-500/20 hover:bg-red-500 text-red-300 hover:text-white border border-red-500/50 px-4 py-2 rounded-lg text-sm transition-all duration-300">
                Logout
            </button>
        </form>
    </div>
</nav>

    {{-- Main Wrapper --}}
    <div class="flex min-h-[calc(100vh-64px)] relative">
        @if ($showAdminSidebar)
            @include('layouts.sidebar')            
        @endif

        {{-- Overlay for mobile --}}
        <div 
            class="fixed inset-0 bg-navy/80 backdrop-blur-sm z-20 md:hidden"
            x-show="openSidebar"
            @click="openSidebar = false"
            x-transition.opacity>
        </div>

        {{-- Halaman Konten --}}
        <main class="flex-1 p-6 md:p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>
            <footer class="text-center py-4 text-sky/50 text-xs border-t border-sky/5 bg-navy">
            &copy; {{ date('Y') }} Bimbel Cakap. All rights reserved.
        </footer>
    @yield('script')
</body>
</html>