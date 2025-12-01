@extends('layouts.create-edit')

@section('title', 'Buat Jadwal Baru')

@section('content')
<div class="container mx-auto max-w-3xl p-6">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white text-center">Buat Data <span class="text-[#FFD700]">Jadwal</span></h1>
        <p class="text-[#A8E8F9] text-sm mt-1 text-center">Atur jadwal pertemuan kelas, mapel, dan tentor.</p>
    </div>

    <form action="{{ route('jadwal.store') }}" 
          method="POST" 
          class="bg-[#00537A] p-8 shadow-2xl rounded-[30px] border border-[#A8E8F9]/20 relative overflow-hidden">
        @csrf

        <div class="grid grid-cols-1 gap-6">

            {{-- SECTION 1: WAKTU (Grid 3 Kolom) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                {{-- HARI --}}
                <div class="relative z-10">
                    <label for="hari" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                        Hari <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <select name="hari" id="hari" 
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                            <option value="" disabled selected>-- Pilih Hari --</option>
                            <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                            <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                            <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                            <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                            <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                            <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                            <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
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
                           value="{{ old('jam_mulai') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none" required>
                    @error('jam_mulai') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- JAM SELESAI --}}
                <div class="relative z-10">
                    <label for="jam_selesai" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                        Jam Selesai <span class="text-red-400">*</span>
                    </label>
                    <input type="time" name="jam_selesai" id="jam_selesai"
                           value="{{ old('jam_selesai') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none" required>
                    @error('jam_selesai') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- SECTION 2: RELASI DATA --}}
            
            {{-- KELAS --}}
            <div class="mb-2 relative z-10">
                <label for="kelas_id" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                    Kelas / Jenjang <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <select name="kelas_id" id="kelas_id" 
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                        <option value="" disabled selected>-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
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

{{-- MATA PELAJARAN --}}
            <div class="mb-2 relative z-10">
                <label for="mata_pelajaran_id" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                    Mata Pelajaran <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    {{-- Tambahkan event onchange agar script jalan saat dipilih --}}
                    <select name="mata_pelajaran_id" id="mata_pelajaran_id" 
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                        <option value="" disabled selected>-- Pilih Mapel --</option>
                        @foreach($mataPelajaran as $mp)
                            <option value="{{ $mp->id }}" {{ old('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
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

            {{-- TENTOR --}}
            <div class="mb-2 relative z-10">
                <label for="tentor_id" class="block font-semibold mb-2 text-[#A8E8F9] text-sm">
                    Tentor Pengajar <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <select name="tentor_id" id="tentor_id" 
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFD700] bg-[#00537A] text-white border-[#A8E8F9] appearance-none cursor-pointer" required>
                        <option value="" disabled selected>-- Pilih Mapel Terlebih Dahulu --</option>
                        
                        @foreach($tentor as $t)
                            {{-- PERHATIKAN: data-mapel di bawah ini --}}
                            {{-- Kita asumsikan di tabel 'tentor' ada kolom 'mata_pelajaran_id' --}}
                            <option value="{{ $t->id }}" 
                                    data-mapel="{{ $t->mata_pelajaran_id }}" 
                                    class="tentor-option hidden"> 
                                {{ $t->user->name ?? 'Tanpa Nama' }}
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
                Simpan Jadwal
            </button>

            {{-- Tombol Batal --}}
            <a href="{{ route('jadwal.index') }}" 
               class="text-[#A8E8F9] hover:text-white text-sm transition font-medium">
                Batal
            </a>
        </div>

    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapelSelect = document.getElementById('mata_pelajaran_id');
        const tentorSelect = document.getElementById('tentor_id');
        const tentorOptions = document.querySelectorAll('.tentor-option');

        // Fungsi untuk filter tentor
        function filterTentor() {
            const selectedMapelId = mapelSelect.value;

            // Reset pilihan tentor ke default
            tentorSelect.value = "";
            
            // Loop semua opsi tentor
            tentorOptions.forEach(option => {
                if (selectedMapelId === "" || option.getAttribute('data-mapel') == selectedMapelId) {
                    // Jika cocok, tampilkan (hapus class hidden)
                    option.classList.remove('hidden');
                    option.disabled = false;
                } else {
                    // Jika tidak cocok, sembunyikan
                    option.classList.add('hidden'); // Pakai class Tailwind 'hidden' / display:none
                    option.disabled = true; // Disable agar tidak bisa dipilih lewat keyboard
                }
            });

            // Update teks placeholder
            if(selectedMapelId) {
                tentorSelect.options[0].text = "-- Pilih Tentor --";
            } else {
                tentorSelect.options[0].text = "-- Pilih Mapel Terlebih Dahulu --";
            }
        }

        // Jalankan fungsi saat Mapel berubah
        mapelSelect.addEventListener('change', filterTentor);

        // (Opsional) Jalankan sekali saat halaman dimuat (untuk kasus Edit / Old Value)
        if(mapelSelect.value) {
            filterTentor();
            // Kembalikan value tentor jika ada old input (validasi error)
            const oldTentor = "{{ old('tentor_id') }}";
            if(oldTentor) {
                tentorSelect.value = oldTentor;
            }
        }
    });
</script>
@endsection