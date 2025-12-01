@extends('layouts.create-edit')

@section('title', 'Pilih Kelas')

@section('content')
{{-- Container diperkecil padding dan max-width --}}
<div class="container mx-auto max-w-5xl p-4">

    {{-- Margin bawah dikurangi, font diperkecil --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-5">
        <div>
            <h1 class="text-2xl font-bold text-white">Pilih <span class="text-lightgold">Kelas</span></h1>
            <p class="text-sky text-xs mt-0.5">Daftar Jadwal Kelas</p>
        </div>
    </div>

    {{-- Radius rounded dikurangi --}}
    <div class="bg-teal rounded-[20px] shadow-2xl border border-sky/10 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                {{-- Padding header dikurangi --}}
                <thead class="bg-navy text-sky uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="py-3 px-3 text-center">NO</th>
                        <th class="py-3 px-3 text-center">Hari & Waktu</th>
                        <th class="py-3 px-3 text-center">Kelas</th>
                        <th class="py-3 px-3 text-center">Mata Pelajaran</th>
                        <th class="py-3 px-3 text-center">Kapasitas</th> 
                        <th class="py-3 px-3 text-left">Tentor Pengajar</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-sky/10 text-xs"> {{-- Default text size diperkecil ke xs --}}
                    @forelse ($jadwal as $key => $j)
                        @php
                            $max_capacity = 20; 
                            $current_students = $j->siswa_count ?? 0; 
                            $is_full = $current_students >= $max_capacity;
                            $is_joined = in_array($j->id, $jadwal_diikuti??[]);
                        @endphp
                        
                        {{-- Hover transition tetap, padding baris dikurangi drastis --}}
                        <tr class="hover:bg-navy/30 transition duration-200 group">

                            <td class="px-3 py-2.5 text-gray-400 group-hover:text-white font-mono text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-3 py-2.5 text-center">
                                <div class="flex flex-col gap-0.5 items-center">
                                    {{-- Badge hari diperkecil --}}
                                    <span class="inline-block bg-[#FFD700]/10 text-[#FFD700] px-1.5 py-0.5 rounded-[4px] text-[10px] font-bold border border-[#FFD700]/30">
                                        {{ strtoupper($j->hari) }}
                                    </span>

                                    <div class="text-white font-mono text-xs flex items-center gap-1 justify-center">
                                        <svg class="w-2.5 h-2.5 text-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-3 py-2.5 text-center">
                                <div class="text-white font-bold text-xs">{{ $j->kelas->nama_kelas }}</div>
                                <div class="text-[10px] text-gray-300">
                                    Tingkat: {{ $j->kelas->kelas }}
                                </div>
                            </td>

                            <td class="px-3 py-2.5 text-center text-white/80">
                                {{ $j->mataPelajaran->nama_mapel }}
                            </td>
                            
                            <td class="px-3 py-2.5 text-center">
                                <span class="font-bold text-xs
                                @if($is_full)
                                    text-red-400 
                                @else 
                                    text-green-400 
                                @endif">
                                    {{ $current_students }} / {{ $max_capacity }}
                                </span>
                            </td>

                            <td class="px-3 py-2.5 text-left">
                                <div class="flex items-center gap-2">
                                    {{-- Avatar diperkecil w-6 h-6 --}}
                                    <div class="text-center w-6 h-6 rounded-full bg-navy flex items-center justify-center text-[10px] font-bold text-sky border border-sky/30">
                                        {{ substr($j->tentor->user->name ?? 'T', 0, 1) }}
                                    </div>
                                    <span class="text-gray-300 text-xs ml-0.5">
                                        {{ $j->tentor->user->name ?? 'Tentor Tidak Ditemukan' }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-3 py-2.5 text-center">
                                @if ($is_joined)
                                    {{-- Tombol diperkecil padding px-3 py-1 --}}
                                    <button class="bg-sky/20 text-sky font-bold px-3 py-1 rounded-md shadow-inner cursor-not-allowed border border-sky/30 text-[10px]" disabled>
                                        Sudah Bergabung
                                    </button>
                                @elseif ($is_full)
                                    <button class="bg-red-600/20 text-red-400 font-bold px-3 py-1 rounded-md shadow-inner cursor-not-allowed border border-red-400/30 text-[10px]" disabled>
                                        Kelas Penuh
                                    </button>
                                @else
                                    <form action="{{ route('siswa.storeKelas') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="jadwal_id" value="{{ $j->id }}">
                                        <input type="hidden" name="tentor_id" value="{{ $j->tentor->id }}">
                                        <button class="bg-gold hover:bg-lightgold text-navy font-bold px-3 py-1 rounded-md shadow transition-all transform hover:-translate-y-0.5 text-[10px]">
                                            Gabung
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 py-8 text-center text-[#A8E8F9]/50 italic text-xs">
                                Belum ada jadwal kelas tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jadwal->hasPages())
            <div class="p-3 border-t border-sky/10 bg-teal text-xs">
                <div class="dark-pagination text-white">
                    {{ $jadwal->links() }}
                </div>
            </div>
        @endif
        
        <div class="w-full flex justify-end p-3 pr-4">
            <a href="{{ route('dashboard-siswa') }}"
                class="flex items-center gap-1.5 text-sky hover:text-lightgold transition text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>
                <span class="font-semibold">Kembali ke Dashboard</span>
            </a>
        </div>
    </div>
</div>
@endsection