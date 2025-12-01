@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="h-screen bg-[#013C58] p-6 text-white font-sans">
    
    <script src="{{ asset('js/app.js') }}" defer></script>

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#FFD35B]">Dashboard Admin</h1>
            <p class="text-[#A8E8F9] mt-1">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }} 👋</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="h-10 w-10 bg-[#00537A] rounded-full flex items-center justify-center border border-[#A8E8F9]/30">
                <span class="text-[#FFBA42]">🔔</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

        {{-- Kartu 1: Jumlah Siswa --}}
        <div class="bg-[#00537A] p-6 rounded-[20px] shadow-lg border-b-4 border-[#F5A201] hover:translate-y-[-5px] transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-sm font-medium text-[#A8E8F9] mb-1 uppercase tracking-wider">Total Siswa</h2>
                    <p class="text-4xl font-bold text-white">{{ $totalSiswa ?? 0 }}</p>
                </div>
                <div class="p-3 bg-[#013C58] rounded-xl text-[#A8E8F9]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
        </div>

        {{-- Kartu 2: Jumlah Tentor --}}
        <div class="bg-[#00537A] p-6 rounded-[20px] shadow-lg border-b-4 border-[#FFBA42] hover:translate-y-[-5px] transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-sm font-medium text-[#A8E8F9] mb-1 uppercase tracking-wider">Total Tentor</h2>
                    <p class="text-4xl font-bold text-white">{{ $totalTentor ?? 0 }}</p>
                </div>
                <div class="p-3 bg-[#013C58] rounded-xl text-[#FFBA42]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        {{-- Kartu 3: Jumlah Kelas --}}
        <div class="bg-[#00537A] p-6 rounded-[20px] shadow-lg border-b-4 border-[#FFD35B] hover:translate-y-[-5px] transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-sm font-medium text-[#A8E8F9] mb-1 uppercase tracking-wider">Total Kelas</h2>
                    <p class="text-4xl font-bold text-white">{{ $totalKelas ?? 0 }}</p>
                </div>
                <div class="p-3 bg-[#013C58] rounded-xl text-[#FFD35B]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
        </div>

        {{-- Kartu 4: Transaksi --}}
        <div class="bg-[#00537A] p-6 rounded-[20px] shadow-lg border-b-4 border-[#A8E8F9] hover:translate-y-[-5px] transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-sm font-medium text-[#A8E8F9] mb-1 uppercase tracking-wider">Pendapatan</h2>
                    <p class="text-2xl font-bold text-[#FFD35B] break-all">
                        Rp {{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="p-3 bg-[#013C58] rounded-xl text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection