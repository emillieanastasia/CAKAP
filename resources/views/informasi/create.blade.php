@extends('layouts.app')

@section('title', 'Tambah Informasi')

@section('content')

<h1 class="text-2xl font-bold text-sky mb-6">Tambah Informasi</h1>

{{-- Error message --}}
@if ($errors->any())
    <div class="mb-4 p-3 bg-red-500/20 text-red-300 border border-red-400 rounded-lg">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- FORM --}}
<div class="bg-teal p-6 rounded-xl shadow-lg border border-sky/20 max-w-3xl">
    <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- JUDUL --}}
        <div class="mb-4">
            <label class="block text-sky font-semibold mb-2">Judul Informasi</label>
            <input type="text" name="judul"
                   class="w-full px-4 py-2 rounded-lg bg-navy text-white border border-sky/30 focus:border-gold focus:ring-1 focus:ring-gold"
                   placeholder="Masukkan judul"
                   required>
        </div>

        {{-- ISI --}}
        <div class="mb-4">
            <label class="block text-sky font-semibold mb-2">Isi Informasi</label>
            <textarea name="isi" rows="6"
                      class="w-full px-4 py-2 rounded-lg bg-navy text-white border border-sky/30 focus:border-gold focus:ring-1 focus:ring-gold"
                      placeholder="Tuliskan isi informasi..."
                      required></textarea>
        </div>

        {{-- GAMBAR --}}
        <div class="mb-4">
            <label class="block text-sky font-semibold mb-2">Upload Gambar (Optional)</label>
            <input type="file" name="gambar" 
                   class="w-full text-white bg-navy border border-sky/30 rounded-lg p-2 cursor-pointer">
        </div>

        {{-- BUTTON --}}
        <div class="flex items-center gap-3 mt-6">
            <button type="submit"
                    class="bg-gold text-navy font-bold px-5 py-2 rounded-lg hover:bg-lightgold transition shadow">
                Simpan
            </button>

            <a href="{{ route('informasi.index') }}"
               class="bg-red-500/20 text-red-300 border border-red-400 px-5 py-2 rounded-lg hover:bg-red-500/40 transition">
                Batal
            </a>
        </div>

    </form>
</div>

@endsection
