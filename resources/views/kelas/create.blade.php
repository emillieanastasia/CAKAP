@extends('layouts.create-edit')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container mx-auto max-w-2xl p-4">

    <div class="mb-4 text-center">
        <h1 class="text-2xl font-bold text-white">Tambah Data <span class="text-[#FFD700]">Kelas</span></h1>
        <p class="text-[#A8E8F9] text-xs mt-1">Tambahkan kelas dan paket bimbingan baru.</p>
    </div>

    <form action="{{ route('kelas.store') }}" 
          method="POST" 
          class="bg-[#00537A] p-5 shadow-xl rounded-2xl border border-[#A8E8F9]/20 relative overflow-hidden">
        @csrf

        <div class="grid grid-cols-1 gap-4">

            {{-- TINGKAT (Select) --}}
            <div class="mb-1 relative z-10">
                <label for="tingkat" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">
                    Jenjang <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <select name="tingkat" id="tingkat" 
                            class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                        <option value="" disabled selected class="text-gray-400">-- Pilih Jejang --</option>
                        <option value="calistung" {{ old('tingkat') == 'calistung' ? 'selected' : '' }} class="bg-[#00537A]">Calistung</option>
                        <option value="sd" {{ old('tingkat') == 'sd' ? 'selected' : '' }} class="bg-[#00537A]">SD</option>
                        <option value="smp" {{ old('tingkat') == 'smp' ? 'selected' : '' }} class="bg-[#00537A]">SMP</option>
                        <option value="sma" {{ old('tingkat') == 'sma' ? 'selected' : '' }} class="bg-[#00537A]">SMA</option>
                        <option value="utbk" {{ old('tingkat') == 'utbk' ? 'selected' : '' }} class="bg-[#00537A]">UTBK</option>
                        <option value="kedinasan" {{ old('tingkat') == 'kedinasan' ? 'selected' : '' }} class="bg-[#00537A]">Kedinasan</option>
                        <option value="kuliah" {{ old('tingkat') == 'kuliah' ? 'selected' : '' }} class="bg-[#00537A]">Kuliah</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#A8E8F9]">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('tingkat') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- NAMA KELAS --}}
            <div class="mb-1 relative z-10">
                <label for="nama_kelas" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">
                    Kelas <span class="text-red-400">*</span>
                </label>
                <input type="text" name="nama_kelas" id="nama_kelas"
                       value="{{ old('nama_kelas') }}"
                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] placeholder-[#A8E8F9]/50" 
                       placeholder="Contoh: I, I, V, VI, X, XI" required>
                @error('nama_kelas') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- MAPEL --}}
            <div class="mb-1 relative z-10">
                <label for="mata_pelajaran_id" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">
                    Mata Pelajaran <span class="text-red-400">*</span>
                </label>
                <select name="mata_pelajaran_id" id="mata_pelajaran_id"
                        class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] placeholder-[#A8E8F9]/50" 
                        required>
                    <option value="" disabled selected>Pilih Mata Pelajaran</option>
                    @foreach($mataPelajaran as $mp)
                        <option value="{{ $mp->id }}" {{ old('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                            {{ $mp->nama_mapel }}
                        </option>
                    @endforeach
                </select>
                @error('mata_pelajaran_id') 
                    <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> 
                @enderror
            </div>

            {{-- HARGA --}}
            <div class="mb-1 relative z-10">
                <label for="harga" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">
                    Harga <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#A8E8F9] text-xs">Rp</span>
                    <input type="number" name="harga" id="harga"
                           value="{{ old('harga') }}"
                           class="w-full border rounded pl-8 pr-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] placeholder-[#A8E8F9]/50" 
                           placeholder="150000" required>
                </div>
                @error('harga') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

        </div>

        {{-- TOMBOL AKSI --}}
        <div class="relative z-10 flex justify-end items-center gap-3 mt-6 pt-3 border-t border-[#A8E8F9]/20">
            {{-- Tombol Simpan --}}
            <button type="submit" class="bg-gold hover:bg-lightgold text-navy font-bold py-2 px-6 rounded-lg text-sm shadow-md transition-all transform hover:-translate-y-0.5">
                Simpan
            </button>

            {{-- Tombol Batal --}}
            <a href="{{ route('kelas.index') }}" 
               class="text-[#A8E8F9] hover:text-white text-xs transition font-medium">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection