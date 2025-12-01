@extends('layouts.app')
@section('title', 'Tambah Mata Pelajaran')

@section('content')
<div class="container mx-auto max-w-2xl p-4">

    {{-- HEADER --}}
    <div class="mb-4 text-center">
        <h1 class="text-2xl font-bold text-white">
            Tambah <span class="text-lightgold">Mapel</span>
        </h1>
        <p class="text-sky text-xs mt-0.5">Isi data mata pelajaran baru.</p>
    </div>

    {{-- CARD FORM --}}
    <div class="bg-teal rounded-2xl shadow-xl border border-sky/10 p-5">

        <form action="{{ route('matapelajaran.store') }}" method="POST">
            @csrf

            {{-- INPUT NAMA MAPEL --}}
            <div class="mb-3">
                <label class="block text-white font-semibold mb-1 text-xs">Nama Mata Pelajaran</label>
                <input type="text" 
                       name="nama_mapel"
                       class="w-full px-3 py-2 rounded-lg bg-navy border border-sky/20 text-white placeholder-sky/40 text-sm
                              focus:ring-1 focus:ring-lightgold focus:outline-none transition"
                       placeholder="Masukkan nama mata pelajaran"
                       required>
            </div>

            {{-- INPUT DESKRIPSI --}}
            <div class="mb-3">
                <label class="block text-white font-semibold mb-1 text-xs">Deskripsi</label>
                <textarea name="deskripsi"
                          class="w-full px-3 py-2 rounded-lg bg-navy border border-sky/20 text-white placeholder-sky/40 text-sm
                                 focus:ring-1 focus:ring-lightgold focus:outline-none transition"
                          rows="3"
                          placeholder="Masukkan deskripsi mata pelajaran"
                          required></textarea>
            </div>

            {{-- TOMBOL --}}
            <div class="flex justify-end gap-3 mt-5 pt-3 border-t border-sky/10">

                {{-- KEMBALI --}}
                <a href="{{ route('matapelajaran.index') }}" 
                   class="px-4 py-2 rounded-lg bg-gray-500/30 hover:bg-gray-400/30 text-white font-semibold transition text-xs">
                    Kembali
                </a>

                {{-- SIMPAN --}}
                <button type="submit"
                    class="px-5 py-2 rounded-lg bg-gold hover:bg-lightgold text-navy font-bold shadow-md transition-all transform hover:-translate-y-0.5 text-xs">
                    Simpan
                </button>

            </div>
        </form>

    </div>
</div>
@endsection