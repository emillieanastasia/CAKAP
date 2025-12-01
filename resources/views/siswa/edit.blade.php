@extends('layouts.create-edit')

@section('title', 'Edit Data Siswa')

@section('content')
<div class="container mx-auto max-w-2xl p-4">

    <div class="mb-5 text-center">
        <h1 class="text-2xl font-bold text-white">Edit Data <span class="text-lightgold">Siswa</span></h1>
        <p class="text-sky text-xs mt-1">Perbarui data siswa.</p>
    </div>

    {{-- Box Konten --}}
    <form method="POST" action="{{ route('siswa.update', $siswa->id) }}"
        class="bg-teal p-6 shadow-xl rounded-2xl border border-sky/10 relative overflow-hidden">
        @csrf
        @method('PUT')

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

        {{-- Grid Utama 2 Kolom --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Kolom 1: Nama & Tanggal Lahir --}}

            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">Nama Lengkap *</label>
                <input type="text" name="name"
                    value="{{ old('name', $siswa->user->name) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="Masukkan nama siswa" style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;" required>
                @error('name') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">Email *</label>
                <input type="email" name="email"
                    value="{{ old('email', $siswa->user->email) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none" 
                    placeholder="email@contoh.com"
                    style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;" required>
                @error('email') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">Tanggal Lahir *</label>
                <input type="date" name="tanggal_lahir"
                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;" required>
                @error('tanggal_lahir') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">No HP *</label>
                <input type="text" name="no_hp"
                    value="{{ old('no_hp', $siswa->no_hp) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="08xxxxxxxxxx"
                    style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;" required>
                @error('no_hp') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">Kelas *</label>
                <div class="relative">
                    <select name="kelas" 
                        class="w-full bg-[#00537A] border border-[#A8E8F9] text-white rounded px-3 py-2 text-sm focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition appearance-none cursor-pointer" required>
                        <option value="">-- Pilih Kelas --</option>
                        @php $selectedKelas = old('kelas', $siswa->kelas); @endphp
                        <option value="Calistung" {{ $selectedKelas == 'Calistung' ? 'selected' : '' }}>Calistung</option>
                        <option value="SD" {{ $selectedKelas == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ $selectedKelas == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ $selectedKelas == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="UTBK" {{ $selectedKelas == 'UTBK' ? 'selected' : '' }}>UTBK</option>
                        <option value="Kedinasan" {{ $selectedKelas == 'Kedinasan' ? 'selected' : '' }}>Kedinasan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-sky">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('kelas') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">Status *</label>
                <div class="relative">
                    <select name="status"
                        class="w-full bg-[#00537A] border border-[#A8E8F9] text-white rounded px-3 py-2 text-sm focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition appearance-none cursor-pointer" required>
                        @php $selectedStatus = old('status', $siswa->status); @endphp
                        <option value="Aktif" {{ $selectedStatus == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $selectedStatus == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-sky">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('status') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>
            
        </div>
        
        {{-- Input: Alamat (Full Width) --}}
        <div class="mb-5 relative z-10">
            <label class="block font-semibold mb-1 text-sky text-xs">Alamat *</label>
            <textarea name="alamat" rows="2"
                class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                placeholder="Masukkan alamat lengkap siswa..."
                style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;" 
                required>{{ old('alamat', $siswa->alamat) }}</textarea>
            @error('alamat') <p class="text-red-400 text-[10px] mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="relative z-10 flex justify-end items-center gap-3 pt-3 border-t border-[#A8E8F9]/20">
            <button type="submit" class="bg-gold hover:bg-lightgold text-navy font-bold px-5 py-2 rounded-lg text-sm shadow-md shadow-gold/20 transition-all duration-300 transform hover:-translate-y-0.5">
                Simpan Perubahan
            </button>
            <a href="{{ route('siswa.index') }}" class="text-sky hover:text-white font-semibold transition-colors text-xs">Batal</a>
        </div>
    </form>

</div>
@endsection