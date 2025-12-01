@extends('layouts.create-edit') 

@section('title', 'Tambah Siswa Baru') 

@section('content')
<div class="container mx-auto max-w-2xl p-4">
    
    {{-- Header --}}
    <div class="mb-4 text-center">
        <h1 class="text-2xl font-bold text-white">Tambah <span class="text-lightgold">Siswa</span></h1>
        <p class="text-sky text-xs mt-1">Isi formulir untuk mendaftarkan siswa.</p>
    </div>
    
    {{-- Box Konten --}}
    <div class="bg-teal rounded-2xl shadow-xl border border-sky/10 p-5 overflow-hidden relative">
        
        {{-- Hiasan Background --}}
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-24 h-24 bg-gold/10 rounded-full blur-xl pointer-events-none"></div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                <strong class="font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Oops! Ada masalah input:
                </strong>
                <ul class="mt-1 list-disc list-inside text-xs opacity-80 pl-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Start --}}
        <form action="{{ route('siswa.store') }}" method="POST">
            @csrf

            {{-- SECTION 1: DATA AKUN SISWA --}}
            <div class="mb-5">
                <h2 class="text-lg font-bold text-sky border-b border-sky/20 pb-1 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Data Akun Siswa
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Input Nama --}}
                    <div>
                        <label for="name" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="name" id="name" 
                            class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] placeholder-white/30 transition-all"
                            placeholder="Contoh: Siti Aisyah"
                            value="{{ old('name') }}" required>
                        @error('name') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Input Email --}}
                    <div>
                        <label for="email" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">Email <span class="text-red-400">*</span></label>
                        <input type="email" name="email" id="email" 
                            class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] placeholder-white/30 transition-all"
                            placeholder="email@contoh.com"
                            value="{{ old('email') }}" required>
                        <p class="text-[10px] text-gray-300 mt-0.5">Password default: <strong class="text-white">password</strong></p>
                        @error('email') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    {{-- Input Password --}}
                    <div>
                        <label for="password" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">Password <span class="text-red-400">*</span></label>
                        <input type="password" name="password" id="password" 
                            class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] placeholder-white/30 transition-all"
                            placeholder="Min 8 karakter"
                            required>
                        @error('password') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Input Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">Konfirmasi Password <span class="text-red-400">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                            class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] placeholder-white/30 transition-all"
                            placeholder="Ulangi password"
                            required>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: DETAIL PROFIL --}}
            <div class="mb-5">
                <h2 class="text-lg font-bold text-sky border-b border-sky/20 pb-1 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Detail Siswa
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Input Tanggal Lahir --}}
                    <div>
                        <label for="tanggal_lahir" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">Tanggal Lahir <span class="text-red-400">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                            class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] placeholder-white/30 transition-all"
                            value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Input No HP --}}
                    <div>
                        <label for="no_hp" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">No HP <span class="text-red-400">*</span></label>
                        <input type="text" name="no_hp" id="no_hp" 
                            class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] placeholder-white/30 transition-all"
                            placeholder="08xxxxxxxxxx"
                            value="{{ old('no_hp') }}" required>
                        @error('no_hp') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Baris 2: Kelas & Status --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    {{-- Input Kelas --}}
                    <div class="relative">
                        <label for="kelas" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">Kelas <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select name="kelas" id="kelas" 
                                class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="Calistung" {{ old('kelas') == 'Calistung' ? 'selected' : '' }}>Calistung</option>
                                <option value="SD" {{ old('kelas') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('kelas') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('kelas') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="UTBK" {{ old('kelas') == 'UTBK' ? 'selected' : '' }}>UTBK</option>
                                <option value="Kedinasan" {{ old('kelas') == 'Kedinasan' ? 'selected' : '' }}>Kedinasan</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#A8E8F9]">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('kelas') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Input Status --}}
                    <div class="relative">
                        <label for="status" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">Status <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select name="status" id="status" 
                                class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#A8E8F9]">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('status') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>


                {{-- Input Alamat (Full Width) --}}
                <div class="mt-4">
                    <label for="alamat" class="block font-semibold mb-1 text-[#A8E8F9] text-xs">Alamat <span class="text-red-400">*</span></label>
                    <textarea name="alamat" id="alamat" rows="2" 
                        class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] placeholder-white/30 transition-all"
                        placeholder="Masukkan alamat lengkap siswa..." required>{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="relative z-10 flex justify-end items-center gap-3 mt-6 pt-3 border-t border-[#A8E8F9]/20">
                <button type="submit" class="bg-gold hover:bg-lightgold text-navy font-bold py-2 px-6 rounded-lg text-sm shadow-md transition-all transform hover:-translate-y-0.5">
                    Simpan
                </button>
                <a href="{{ route('siswa.index') }}" class="text-gray-400 hover:text-white font-semibold transition-colors text-xs font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection