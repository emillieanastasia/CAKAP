@extends('layouts.create-edit')

@section('title', 'Edit Tentor')

@section('content')
<div class="container mx-auto max-w-xl p-4">

    <div class="mb-4 text-center">
        <h1 class="text-2xl font-bold text-white">Edit Data <span class="text-lightgold">Tentor</span></h1>
        <p class="text-sky text-xs mt-1">Perbarui data tentor.</p>
    </div>

    <form method="POST" action="{{ route('tentor-update', $tentor->id) }}"
          class="bg-teal p-5 shadow-xl rounded-2xl border border-sky/10 relative overflow-hidden">
        @csrf
        @method('PUT')
        
        {{-- Hiasan Background (Opsional, agar sama dengan create) --}}
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-24 h-24 bg-gold/10 rounded-full blur-xl pointer-events-none"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Input Nama --}}
            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">Nama Lengkap</label>
                <input type="text" name="name"
                    value ="{{ old('name', $tentor->user->name) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="Masukkan nama tentor" 
                    style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;" required>
            </div>

            {{-- MODIFIKASI: Input Mata Pelajaran (Dropdown) --}}
            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">Mata Pelajaran (Keahlian)</label>
                <div class="relative">
                    <select name="mata_pelajaran_id" 
                        class="w-full border rounded px-3 py-2 text-sm focus:outline-none appearance-none cursor-pointer"
                        style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;" required>
                        
                        <option value="" disabled>-- Pilih Mapel --</option>
                        
                        @foreach($mataPelajaran as $mapel)
                            <option value="{{ $mapel->id }}" 
                                {{-- Logic: Cek old input, jika null cek database --}}
                                {{ old('mata_pelajaran_id', $tentor->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach

                    </select>
                    {{-- Icon Panah --}}
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#A8E8F9]">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Input Pendidikan --}}
            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">Pendidikan Terakhir</label>
                <input type="text" name="pendidikan_terakhir"
                    value="{{ old('pendidikan_terakhir', $tentor->pendidikan_terakhir) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="Masukkan Pendidikan Terakhir"
                    style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;">
            </div>

            {{-- Input Alamat --}}
            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">Alamat</label>
                <input type="text" name="alamat" 
                    value="{{ old('alamat', $tentor->alamat) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none" 
                    placeholder="Masukkan Alamat"
                    style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;" required>
            </div>

            {{-- Input No HP --}}
            <div class="mb-3 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">No HP</label>
                <input type="text" name="no_hp"
                    value="{{ old('no_hp', $tentor->no_hp) }}"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none"
                    placeholder="Masukkan Nomor Hp"
                    style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;">
            </div>

            {{-- Input Status --}}
            <div class="mb-5 relative z-10">
                <label class="block font-semibold mb-1 text-sky text-xs">Status</label>
                <div class="relative">
                    <select name="status" 
                        class="w-full border rounded px-3 py-2 text-sm focus:outline-none appearance-none cursor-pointer"
                        style="background-color: #00537A; color: #FFFFFF; border-color: #A8E8F9;" required>
                        <option value="aktif" {{ old('status', $tentor->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ old('status', $tentor->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#A8E8F9]">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative z-10 flex justify-end items-center gap-3 pt-3 border-t border-[#A8E8F9]/20">
            <button class="bg-gold hover:bg-lightgold text-navy font-bold px-5 py-2 rounded-lg text-sm shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                Simpan Perubahan
            </button>
            {{-- Benar --}}
<a href="/tentor" class="text-sky hover:text-white text-xs transition font-medium">Batal</a>
        </div>
    </form>

</div>
@endsection