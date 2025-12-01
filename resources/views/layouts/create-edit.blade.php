<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CAKAP</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Konfigurasi Palet Warna Twine.net (Sama dengan app.blade.php) --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#013C58',       // Background Gelap
                        teal: '#00537A',       // Warna Kartu/Navbar
                        sky: '#A8E8F9',        // Teks Aksen/Secondary
                        gold: '#F5A201',       // Highlight Utama
                        lightgold: '#FFD35B',  // Highlight Sekunder
                        pale: '#FFBA42',       // Aksen Tambahan
                    }
                }
            }
        }
    </script>

    {{-- Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-navy font-sans text-white">

    {{-- NAVBAR (Tanpa Tombol Hamburger Sidebar) --}}
    <nav class="bg-teal border-b border-sky/10 shadow-lg px-4 py-3 flex justify-between items-center sticky top-0 z-30">
        
        {{-- Logo Area --}}
        <div>
            <a href="/" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 object-contain">
                <span class="font-bold text-xl text-white tracking-wide">BIMBEL <span class="text-gold">CAKAP</span></span>
            </a>
        </div>
    </nav>

    {{-- Main Wrapper (Full Width) --}}
    <main class="min-h-[calc(100vh-64px)] w-full relative">
        {{-- Slot Konten Utama --}}
        <div class="p-6 md:p-8">
            @yield('content')
        </div>
    </main>

    {{-- Footer (Opsional, agar tidak kosong di bawah) --}}
    <footer class="text-center py-4 text-sky/50 text-xs border-t border-sky/5 bg-navy">
        &copy; {{ date('Y') }} Bimbel Cakap. All rights reserved.
    </footer>

</body>
</html>