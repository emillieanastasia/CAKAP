@extends('layouts.create-edit')
@section('title', 'Rincian Kelas')
@section('content')
{{-- Mengurangi padding kontainer utama --}}
<div class="container mx-auto p-3 sm:p-4 max-w-4xl"> 
    {{-- Header Page --}}
    {{-- Mengurangi margin bawah dan ukuran font header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            {{-- Mengurangi ukuran font h1 --}}
            <h1 class="text-2xl font-bold text-white">Rincian <span class="text-lightgold">Kelas</span></h1>
            {{-- Mengurangi ukuran font deskripsi --}}
            <p class="text-sky text-xs mt-1">Kenali Teman Sekelasmu!!</p>
        </div>
        {{-- Mengurangi padding dan ukuran font tombol --}}
        <a href="{{ route('dashboard-siswa') }}" class="inline-flex items-center text-yellow-400 hover:text-yellow-300 transition duration-150 ease-in-out font-medium text-sm mt-3 md:mt-0">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>
    
    {{-- DETAIL JADWAL --}}
    {{-- Mengurangi padding kontainer detail jadwal --}}
    <div class="bg-[#013C58] rounded-lg shadow-lg p-4 mb-6 border border-yellow-400">
        {{-- Mengurangi ukuran font detail --}}
        <p class="mb-2 border-b border-yellow-400/30 pb-1.5">
            <span class="font-bold text-base text-yellow-400">Mata Pelajaran:</span> 
            <span class="ml-2 text-lg font-semibold text-white">{{ $jadwalKelas->mapel->nama_mapel }}</span>
        </p>

        <p class="mb-2 border-b border-yellow-400/30 pb-1.5">
            <span class="font-bold text-base text-yellow-400">Kelas:</span> 
            <span class="ml-2 text-white">{{ $jadwalKelas->kelas->nama_kelas }}</span>
        </p>

        <p class="mb-2 border-b border-yellow-400/30 pb-1.5">
            <span class="font-bold text-base text-yellow-400">Jam:</span> 
            <span class="ml-2 text-white">{{ $jadwalKelas->jam_mulai }} - {{ $jadwalKelas->jam_selesai }}</span>
        </p>

        <p class="mb-0">
            <span class="font-bold text-base text-yellow-400">Tentor:</span> 
            <span class="ml-2 text-white">{{ $jadwalKelas->tentor->user->name ?? 'N/A' }}</span>
        </p>
    </div>
    
    {{-- Tabel Rincian Siswa --}}
    <h2 class="text-xl font-bold text-white mb-3">Daftar Siswa</h2> {{-- Tambahkan sub-judul --}}
    <div class="bg-teal rounded-lg shadow-2xl border border-sky/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm"> {{-- Mengurangi ukuran font tabel --}}
                <thead class="bg-navy text-sky uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th scope="col" class="px-4 py-2 text-left uppercase tracking-wider">
                            NO
                        </th>
                        <th scope="col" class="px-4 py-2 text-left uppercase tracking-wider">
                            NAMA SISWA
                        </th>
                        <th scope="col" class="px-4 py-2 text-left uppercase tracking-wider">
                            NOMOR HP
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sky/10">
                    @forelse ($siswa as $index => $s)
                        <tr class="hover:bg-navy/30 transition duration-200 group text-gray-300">
                            <td class="py-2.5 px-4 font-mono">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap text-white">
                                {{ $s->user->name ?? 'Nama Tidak Ditemukan' }}
                            </td>
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                {{ $s->user->siswa->no_hp ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-[#013C58]">
                            <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-400">
                                Belum ada siswa yang terdaftar pada jadwal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection