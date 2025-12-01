@extends('layouts.create-edit')

@section('title', 'Edit Jadwal Kelas')

@section('content')
<div class="container mx-auto max-w-3xl p-6">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white text-center">Edit Data <span class="text-[#FFD700]">Jadwal</span></h1>
        <p class="text-[#A8E8F9] text-sm mt-1 text-center">Perbarui informasi jadwal belajar mengajar.</p>
    </div>

    <form action="{{ route('jadwal.update', $jadwal->id) }}" 
          method="POST" 
          class="bg-[#00537A] p-8 shadow-2xl rounded-[30px] border border-[#A8E8F9]/20 relative overflow-hidden">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6">

            {{-- ROW 1: HARI & WAKTU (3 Kolom) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- HARI --}}
                <div class="relative z-10">
                    <label for="hari" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                        Hari <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <select name="hari" id="hari" 
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                            <option value="" disabled>-- Pilih Hari --</option>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                <option value="{{ $hari }}" {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>
                                    {{ $hari }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#A8E8F9]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('hari') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- JAM MULAI --}}
                <div class="relative z-10">
                    <label for="jam_mulai" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                        Jam Mulai <span class="text-red-400">*</span>
                    </label>
                    <input type="time" name="jam_mulai" id="jam_mulai"
                           value="{{ old('jam_mulai', \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) }}"
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9]" required>
                    @error('jam_mulai') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- JAM SELESAI --}}
                <div class="relative z-10">
                    <label for="jam_selesai" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                        Jam Selesai <span class="text-red-400">*</span>
                    </label>
                    <input type="time" name="jam_selesai" id="jam_selesai"
                           value="{{ old('jam_selesai', \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')) }}"
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9]" required>
                    @error('jam_selesai') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- ROW 2: KELAS (Select Relation) --}}
            <div class="mb-2 relative z-10">
                <label for="kelas_id" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                    Kelas / Tingkat <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <select name="kelas_id" id="kelas_id"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                        <option value="" disabled>-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $jadwal->kelas_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->kelas }})
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#A8E8F9]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('kelas_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- ROW 3: MATA PELAJARAN (Select Relation) --}}
            <div class="mb-2 relative z-10">
                <label for="mata_pelajaran_id" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                    Mata Pelajaran <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <select name="mata_pelajaran_id" id="mata_pelajaran_id"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                        <option value="" disabled>-- Pilih Mapel --</option>
                        @foreach($mataPelajaran as $mp)
                            <option value="{{ $mp->id }}" {{ old('mata_pelajaran_id', $jadwal->mata_pelajaran_id) == $mp->id ? 'selected' : '' }}>
                                {{ $mp->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#A8E8F9]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('mata_pelajaran_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- ROW 4: TENTOR (Select Relation) --}}
            <div class="mb-2 relative z-10">
                <label for="tentor_id" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                    Tentor Pengajar <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <select name="tentor_id" id="tentor_id"
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                        <option value="" disabled>-- Pilih Tentor --</option>
                        @foreach($tentor as $t)
                            <option value="{{ $t->id }}" {{ old('tentor_id', $jadwal->tentor_id) == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#A8E8F9]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('tentor_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

        </div>

        {{-- TOMBOL AKSI --}}
        <div class="relative z-10 flex justify-end items-center gap-4 mt-8 pt-4 border-t border-[#A8E8F9]/20">
            {{-- Tombol Simpan --}}
            <button type="submit" class="bg-gold hover:bg-lightgold text-navy font-bold py-3 px-8 rounded-xl shadow-lg shadow-gold/20 transition-all transform hover:-translate-y-1">
                Simpan Perubahan
            </button>

            {{-- Tombol Batal --}}
            <a href="{{ route('jadwal.index') }}" 
               class="text-[#A8E8F9] hover:text-white text-sm transition font-medium">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection