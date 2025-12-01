@extends('layouts.create-edit')

@section('title','Edit Mata Pelajaran')

@section('content')
<div class="container mx-auto max-w-xl p-4">

    <div class="mb-4 text-center">
        <h1 class="text-2xl font-bold text-white">
            Edit <span class="text-[#FFD700]">Mapel</span>
        </h1>
        <p class="text-[#A8E8F9] text-xs mt-0.5">Perbarui data mata pelajaran.</p>
    </div>

    {{-- Form Container --}}
    <form action="{{ route('matapelajaran.update', $mataPelajaran->id) }}" 
          method="POST"
          class="bg-[#00537A] p-5 shadow-xl rounded-2xl border border-[#A8E8F9]/20 relative overflow-hidden">
        
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-4 mb-2">
            
            {{-- Nama Mata Pelajaran --}}
            <div class="mb-1 relative z-10">
                <label for="nama_mapel" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">
                    Nama Mata Pelajaran <span class="text-red-400">*</span>
                </label>
                <input type="text" 
                       name="nama_mapel" 
                       id="nama_mapel"
                       value="{{ old('nama_mapel', $mataPelajaran->nama_mapel) }}"
                       class="w-full border rounded px-3 py-2 text-sm bg-[#00537A] text-white border-[#A8E8F9]
                              focus:outline-none focus:ring-1 focus:ring-[#FFD700] placeholder-[#A8E8F9]/50 shadow-inner" 
                       placeholder="Contoh: Matematika Dasar"
                       required>
                
                @error('nama_mapel')
                    <p class="text-red-400 text-[10px] mt-1 flex items-center gap-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Deskripsi (Text Area Biasa) --}}
            <div class="mb-1 relative z-10">
                <label for="deskripsi" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">
                    Deskripsi <span class="text-red-400">*</span>
                </label>

                <textarea name="deskripsi"
                          id="deskripsi"
                          rows="3"
                          class="w-full border rounded px-3 py-2 text-sm bg-[#00537A] text-white border-[#A8E8F9]
                                 focus:outline-none focus:ring-1 focus:ring-[#FFD700] placeholder-[#A8E8F9]/50 shadow-inner"
                          placeholder="Contoh: Mata pelajaran ini membahas dasar–dasar matematika..."
                          required>{{ old('deskripsi', $mataPelajaran->deskripsi) }}</textarea>

                @error('deskripsi')
                    <p class="text-red-400 text-[10px] mt-1 flex items-center gap-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        {{-- Tombol Aksi --}}
        <div class="relative z-10 flex justify-end items-center gap-3 mt-5 pt-3 border-t border-[#A8E8F9]/20">
            
            {{-- Tombol Simpan --}}
            <button type="submit" 
                    class="bg-[#FFD700] hover:bg-[#D4AF37] text-[#002b40] font-bold px-5 py-2 rounded-lg text-sm
                           shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                Simpan
            </button>

            {{-- Tombol Batal --}}
            <a href="{{ route('matapelajaran.index') }}" 
               class="text-[#A8E8F9] hover:text-white text-xs transition font-medium">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection