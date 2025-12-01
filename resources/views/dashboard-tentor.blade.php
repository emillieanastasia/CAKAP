@extends('layouts.app')
@section('title','Dashboard Tentor')

@section('head')
<style>
.custom-scroll::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}
.custom-scroll::-webkit-scrollbar-track {
    background: #00537A;
    border-radius: 8px;
}
.custom-scroll::-webkit-scrollbar-thumb {
    background-color: #FFD700;
    border-radius: 8px;
    border: 2px solid #00537A;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
    background-color: #F5A201;
}
.custom-scroll {
    scrollbar-width: thin;
    scrollbar-color: #F5A201 #00537A;
}
</style>
@endsection

@section('content')
<div class="h-100% bg-[#013C58] p-3 sm:px-4 lg:px-6 font-sans text-white overflow-hidden">
    {{-- BAGIAN 1. KANAN DAN KIRI --}}
    <div class="flex flex-col lg:flex-row gap-4 w-full">
        
        {{-- BAGIAN KIRI - STATISTIK & JADWAL --}}
        <div class="w-full lg:flex-[3] flex flex-col mb-4 lg:mb-0">
            
            {{-- Greeting Card --}}
            <div class="bg-[#00537A] p-4 rounded-[16px] border-l-4 border-[#FFD700] shadow-md mb-6 relative overflow-hidden">
                <div class="relative z-10">
                    <h5 class="text-lg font-bold text-white mb-1">Halo, {{ Auth::user()->name }} 👋</h5>
                    <p class="text-[#A8E8F9] text-xs max-w-md">Siap mengajar? Cek jadwal Anda di bawah ini.</p>
                </div>
            </div>

            {{-- Statistik (Grid disesuaikan dengan 2 data yang tersedia) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                {{-- Card 1: Total Kelas --}}
                <div class="bg-[#00537A] p-4 rounded-[16px] shadow-lg border-t-2 border-[#A8E8F9]">
                    <h6 class="text-[10px] font-bold text-[#A8E8F9] uppercase tracking-wider mb-1">Total Kelas</h6>
                    <h3 class="text-2xl font-extrabold text-white">{{ $totalKelas }}</h3>
                </div>
                
                {{-- Card 2: Jadwal Hari Ini --}}
                <div class="bg-[#00537A] p-4 rounded-[16px] shadow-lg border-t-2 border-[#FFD700]">
                    <h6 class="text-[10px] font-bold text-gold uppercase tracking-wider mb-1">Jadwal Hari Ini</h6>
                    <h3 class="text-2xl font-extrabold text-white">{{ $jadwalHariIni->count() }}</h3>
                </div>
            </div>
            {{-- Jadwal Mengajar --}}
            <div class="bg-[#00537A] p-5 rounded-[16px] shadow-xl border border-[#A8E8F9]/10 flrx-grow">
                <h5 class="text-lg font-bold text-white mb-4 border-b border-[#A8E8F9]/20 pb-2">Jadwal Mengajar</h5>

                @if($jadwal->isEmpty())
                    <p class="text-[#A8E8F9] italic text-xs">Belum ada jadwal mengajar.</p>
                @else
                    <div class="overflow-x-auto overflow-y-auto max-h-[150px] custom-scroll">
                        <table class="min-w-full text-left text-xs border-gold">
                            <thead class="bg-[#013C58]">
                                <tr>
                                    <th class="px-4 py-2 font-bold text-gold uppercase tracking-wider">Kelas</th>
                                    <th class="px-4 py-2 font-bold text-gold uppercase tracking-wider">Hari</th>
                                    <th class="px-4 py-2 font-bold text-gold uppercase tracking-wider">Waktu</th>
                                    <th class="px-4 py-2 font-bold text-gold uppercase tracking-wider text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#A8E8F9]/10">
                                @foreach($jadwal as $j)
                                <tr class="hover:bg-[#013C58]/50 transition">
                                    <td class="px-4 py-3 text-white">
                                        <div class="font-bold">{{ $j->kelas->nama_kelas ?? '-' }}</div>
                                        <div class="text-[10px] text-[#A8E8F9]">{{ $j->kelas->kelas ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-[#A8E8F9]">
                                        {{ $j->hari }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-300 font-mono">
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('absensi.rekap', $j->kelas->id) }}"
                                           class="inline-block px-3 py-1.5 text-[10px] uppercase tracking-wide bg-gold hover:bg-yellow-500 text-[#013C58] font-bold rounded shadow transition-colors">
                                            Absensi
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- BAGIAN KANAN - PROFIL --}}
        <div class="w-full lg:flex-[1] flex-shrink-0">
            <div class="bg-[#00537A] p-4 rounded-[16px] shadow-xl border border-[#A8E8F9]/10 sticky top-4 h-full">
                <h5 class="text-lg font-bold text-white mb-4 border-b border-[#A8E8F9]/20 pb-2">Profil Tentor</h5>
                
                {{-- Tombol Edit Profil --}}
                <a href="{{ route('tentor.edit.profil') }}" class="absolute top-2 right-4 bg-gold hover:bg-yellow-500 text-[#013C58] font-bold p-2 rounded-full shadow-lg shadow-[#FFD700]/10 transition-all transform hover:-translate-y-1 hover:shadow-[#FFD700]/30" title="Edit Profil">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>

                <div class="flex flex-col gap-3 text-sm">
                    <div>
                        <p class="text-xs text-[#A8E8F9]">Nama</p>
                        <p class="text-white font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#A8E8F9]">Email</p>
                        <p class="text-white font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#A8E8F9]">Password</p>
                        <p class="text-white font-medium">**********</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#A8E8F9]">Keahlian</p>
                        <p class="text-white font-medium">{{ $tentor->mataPelajaran->nama_mapel ?? 'Data Tidak Ditemukan' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#A8E8F9]">No. HP</p>
                        <p class="text-white font-medium">{{ $tentor->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#A8E8F9]">Pendidikan Terakhir</p>
                        <p class="text-white font-medium">{{ $tentor->pendidikan_terakhir ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#A8E8F9]">Alamat</p>
                        <p class="text-white font-medium leading-relaxed">{{ $tentor->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection