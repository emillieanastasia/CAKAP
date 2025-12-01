@extends('layouts.app')

@section('title', 'Edit Informasi')

@section('content')

<h1 class="text-2xl font-bold text-sky mb-6">Edit Informasi</h1>

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
    <form action="{{ route('informasi.update', $informasi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- JUDUL --}}
        <div class="mb-4">
            <label class="block text-sky font-semibold mb-2">Judul Informasi</label>
            <input type="text" name="judul"
                   class="w-full px-4 py-2 rounded-lg bg-navy text-white border border-sky/30 focus:border-gold focus:ring-1 focus:ring-gold"
                   value="{{ $informasi->judul }}"
                   required>
        </div>

        {{-- ISI --}}
        <div class="mb-4">
            <label class="block text-sky font-semibold mb-2">Isi Informasi</label>
            <textarea name="isi" rows="6"
                      class="w-full px-4 py-2 rounded-lg bg-navy text-white border border-sky/30 focus:border-gold focus:ring-1 focus:ring-gold"
                      required>{{ $informasi->isi }}</textarea>
        </div>

        {{-- GAMBAR --}}
        <div class="mb-4">
            <label class="block text-sky font-semibold mb-2">Gambar (Jika ingin mengganti)</label>

            {{-- PREVIEW GAMBAR --}}
            @if ($informasi->gambar)
                <img src="{{ asset('uploads/informasi/' . $informasi->gambar) }}" 
                     class="w-40 h-40 object-cover rounded-lg mb-3 border border-sky/30">
            @endif

            <input type="file" name="gambar" 
                   class="w-full text-white bg-navy border border-sky/30 rounded-lg p-2 cursor-pointer">
        </div>

        {{-- BUTTON --}}
        <div class="flex items-center gap-3 mt-6">
            <button type="submit"
                    class="bg-gold text-navy font-bold px-5 py-2 rounded-lg hover:bg-lightgold transition shadow">
                Simpan Perubahan
            </button>

            <a href="{{ route('informasi.index') }}"
               class="bg-red-500/20 text-red-300 border border-red-400 px-5 py-2 rounded-lg hover:bg-red-500/40 transition">
                Batal
            </a>
        </div>

    </form>
</div>

@endsection
