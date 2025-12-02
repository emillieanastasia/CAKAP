@extends('layouts.app')
@section('title','Dashboard')
@section('header_content')
@endsection
@section('content')
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
.pagination li a,
.pagination li span {
    background-color: #FFD700 !important;
    color: #013C58 !important;
    border-radius: 6px;
    padding: 6px 10px;
    font-weight: 600;
    border: none;
}

.pagination li a:hover {
    background-color: #F5A201 !important;
}

.pagination .active span {
    background-color: #F5A201 !important;
    color: #013C58 !important;
}
</style>
@endsection

{{--      DASHBOARD UTAMA --}}
<div class="min-h-screen bg-[#013C58] p-3 sm:px-4 lg:px-6 font-sans text-white">
    {{-- BAGIAN 1. KANAN DAN KIRI --}}
    <div class="flex flex-col lg:flex-row gap-4 w-full">
        {{-- BAGIAN KIRI - STATISTIK--}}
        <div class="w-full lg:flex-[3] flex flex-col mb-4 lg:mb-0">
            {{-- Greeting --}}
            <div class="bg-[#00537A] p-4 rounded-[16px] border-l-4 border-gold shadow-md mb-6 relative overflow-hidden">
                <div class="relative z-10">
                    <h5 class="text-lg font-bold text-white mb-1">Hai, {{ auth()->user()->name }} 👋</h5>
                    <p class="text-[#A8E8F9] text-xs max-w-md">Semangat belajar! Masa depan cerah menantimu.</p>
                </div>
                <a href="{{ route('siswa.pilih.kelas') }}"title="Tambah Kelas"class="absolute bottom-4 right-4 z-20 px-4 py-2 rounded-full bg-gold hover:bg-yellow-500 text-[#013C58] shadow-xl hover:shadow-2xl transition duration-300 transform hover:scale-110 flex items-center gap-2">
                    {{-- Ikon Plus --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg> <span class="font-bold text-sm">Gabung Kelas</span>
                </a>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-[#00537A] p-4 rounded-[16px] shadow-lg border-t-2 border-[#A8E8F9]">
                    <h6 class="text-[10px] font-bold text-[#A8E8F9] uppercase tracking-wider mb-1">Total Jadwal</h6>
                    <h3 class="text-2xl font-extrabold text-white">{{ $totalJadwal }}</h3>
                </div>
                <div class="bg-[#00537A] p-4 rounded-[16px] shadow-lg border-t-2 border-gold">
                    <h6 class="text-[10px] font-bold text-gold uppercase tracking-wider mb-1">Mapel Diikuti</h6>
                    <h3 class="text-2xl font-extrabold text-white">{{ $totalMapel }}</h3>
                </div>
                <div class="bg-[#00537A] p-4 rounded-[16px] shadow-lg border-t-2 border-gold">
                    <h6 class="text-[10px] font-bold text-gold uppercase tracking-wider mb-1">Kelas Saat Ini</h6>
                    <h3 class="text-lg font-extrabold text-white mt-1">{{ $siswa->kelas ?? '-' }}</h3>
                </div>
            </div>

            {{-- Jadwal Hari Ini --}}
            <div class="bg-[#00537A] p-5 rounded-[16px] shadow-xl border border-[#A8E8F9]/10 flex-grow">
                <h5 class="text-lg font-bold text-white mb-4 border-b border-[#A8E8F9]/20 pb-2">Jadwal Hari Ini</h5>

                @if($jadwalHariIni->count() == 0)
                    <p class="text-[#A8E8F9] italic text-xs">Tidak ada jadwal hari ini. Waktunya istirahat!</p>
                @else
                    <div class="overflow-x-auto overflow-y-auto max-h-[150px] custom-scroll">
                        <table class="min-w-full text-left text-xs border-gold">
                            <thead class="bg-[#013C58]">
                                <tr>
                                    <th class="px-4 py-2 font-bold text-gold uppercase tracking-wider">Mata Pelajaran</th>
                                    <th class="px-4 py-2 font-bold text-gold uppercase tracking-wider">Jam</th>
                                    <th class="px-4 py-2 font-bold text-gold uppercase tracking-wider">Tentor</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#A8E8F9]/10">
                                @foreach($jadwalHariIni as $j)
                                <tr class="hover:bg-[#013C58]/50 transition">
                                    <td class="px-4 py-3 text-white">{{ $j->mataPelajaran->nama_mapel ?? 'Tidak Ada Mapel'}}</td>
                                    <td class="px-4 py-3 text-[#A8E8F9]">
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-300 flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-full bg-gold flex items-center justify-center text-[10px] text-[#013C58] font-bold">
                                            {{ substr($j->tentor->user->name, 0, 1) }}
                                        </div>
                                        {{ $j->tentor->user->name }}
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
                <h5 class="text-lg font-bold text-white mb-4 border-b border-[#A8E8F9]/20 pb-2">Profil Siswa</h5>
                        {{-- Tombol Edit di pojok kanan atas --}}
                <a href="{{ route('edit.profil', $siswa->id) }}"class="absolute top-2 right-4 bg-gold hover:bg-yellow-500 text-[#013C58] font-bold p-2 rounded-full shadow-lg shadow-gold/10 transition-all transform hover:-translate-y-1 hover:shadow-gold/30" title="Edit Profil">
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
                        <p class="text-xs text-[#A8E8F9]">Tanggal Lahir</p>
                        <p class="text-white font-medium">{{ $siswa->tanggal_lahir ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#A8E8F9]">No. HP</p>
                        <p class="text-white font-medium">{{ $siswa->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#A8E8F9]">Kelas</p>
                        <p class="text-white font-medium">{{ $siswa->kelas?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#A8E8F9]">Alamat</p>
                        <p class="text-white font-medium">{{ $siswa->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <hr class="mt-8 border-[#A8E8F9]/20">

    {{-- Judul 'Kelas Saya' --}}
    <div class="bg-[#00537A] p-4 rounded-[16px] shadow-lg mb-6 mt-6 border-l-4 border-gold">
        <h2 class="text-xl font-bold text-white" id="kelas-diikuti">Kelas Saya</h2>
        <p class="text-xs text-[#A8E8F9] mt-1">Daftar kelas yang sedang Anda ikuti.</p>
    </div>
        {{-- PESAN SUKSES FULL LEBAR --}}
    @if (session('success'))
        <div class="bg-green-600/20 border-l-4 border-green-500 text-green-100 p-4 rounded-[16px] my-6 shadow-md" role="alert">
            <p class="font-bold text-sm">Berhasil!</p>
            <p class="text-xs">{!! session('success') !!}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-600/20 border-l-4 border-red-500 text-red-100 p-4 rounded-[16px] my-6 shadow-md" role="alert">
            <p class="font-bold text-sm">Gagal!</p>
            <p class="text-xs">{!! session('error') !!}</p>
        </div>
    @endif
    {{-- Daftar Kelas (Grid) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 bg-transparent">
        @forelse ($jadwalDiambil as $j)
        <div class="bg-[#00537A] p-1.5 text-[11px] rounded-lg shadow-md border-t-4 border-gold/70 flex flex-col gap-1.5">
            <div class="flex items-center justify-between mb-1">
                <h3 class="text-lg font-extrabold text-white">
                    {{ $j->mataPelajaran->nama_mapel }}
                </h3>

                {{-- Kontainer Ikon Aksi (DELETE & DETAIL) --}}
                <div class="flex gap-1.5 items-center">
                    {{-- 1. Ikon Hapus/Tinggalkan Kelas (Form DELETE) --}}
                    {{-- >>> START PERUBAHAN FORM UNTUK SWAL <<< --}}
                    <form action="{{ route('siswa.destroyKelas', $j->id) }}" method="POST" class="form-tinggalkan-kelas">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="tombol-tinggalkan text-red-400 hover:text-red-500 transition p-1 rounded-full hover:bg-red-200/10" 
                                title="Tinggalkan Kelas"
                                data-nama="{{ $j->mataPelajaran->nama_mapel }}">
                            {{-- Trash icon SVG --}}
                            <img src="{{ asset('images/hapusm.svg') }}" class="w-4 h-4 color-white" alt="Hapus">
                        </button>
                    </form>

                    {{-- 2. Ikon Rincian (Lihat Detail) --}}
                    <a href="{{ route('siswa.rincian.kelas', $j->id) }}"
                    class="text-gold hover:text-yellow-400 transition p-1 rounded-full hover:bg-gold/10" 
                    title="Rincian Kelas">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                            viewBox="0 0 24 24" stroke-width="1.8" 
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </a>
                </div>
            </div>
            
            {{-- Detail Kelas --}}
            <div>
                <p class="text-xs text-[#A8E8F9] mb-3">
                    Kelas: {{ $j->kelas->nama_kelas }}
                </p>

                <div class="flex items-center gap-2 text-gray-300 text-xs mb-3">
                    {{-- 1. Ikon Jam (Clock Icon - Ganti path) --}}
                    <img src="{{ asset('images/clock.svg') }}" class="w-4 h-4 color-white" alt="Jam">
                    <span>{{ $j->hari }}, {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</span>
                </div>

                <div class="flex items-center gap-2 text-gray-300 text-xs">
                    {{-- 2. Ikon Tentor (User Group Icon - Ganti path) --}}
                    <img src="{{ asset('images/user.svg') }}" class="w-4 h-4 color-white" alt="Tentor">
                    <span>Tentor: {{ $j->tentor->user->name }}</span>
                </div>
            </div>
        </div>
        @empty
            <p class="text-gray-400 text-sm">Belum ada kelas yang diikuti.</p>
        @endforelse
    </div>
    
    {{-- Pagination dipindahkan ke luar grid, di kanan bawah --}}
    @if($jadwalDiambil->hasPages())
        <div class="mt-4 flex justify-end"> {{-- Menggunakan justify-end untuk meratakan ke kanan --}}
            {{ $jadwalDiambil->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Target semua form dengan class 'form-tinggalkan-kelas'
    document.querySelectorAll('.form-tinggalkan-kelas').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Ambil nama kelas dari data attribute tombol
            let nama = this.querySelector('.tombol-tinggalkan').getAttribute('data-nama');

            Swal.fire({
                title: 'Tinggalkan Kelas?',
                text: "Anda akan meninggalkan kelas \"" + nama + "\" dan tidak dapat membatalkan tindakan ini.",
                icon: 'warning',
                background: '#013C58', // Sesuaikan dengan warna background gelap Anda
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah untuk aksi tinggalkan
                cancelButtonColor: '#FFD700', // Gold/Kuning untuk batal
                confirmButtonText: 'Ya, Tinggalkan!',
                cancelButtonText: 'Batal',
                customClass: {
                    cancelButton: 'text-[#013C58] font-bold' // Agar teks Batal berwarna biru tua
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit form jika user konfirmasi
                }
            });
        });
    });
});
</script>
@endsection
@endsection
