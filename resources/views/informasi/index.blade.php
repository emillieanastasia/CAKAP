@extends('layouts.app')

@section('title', 'Informasi')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-sky">Daftar Informasi</h1>

    <a href="{{ route('informasi.create') }}" 
       class="bg-gold text-navy font-semibold px-4 py-2 rounded-lg shadow hover:bg-lightgold transition">
        + Tambah Informasi
    </a>
</div>

@if (session('success'))
    <div class="mb-4 p-3 bg-green-500/20 border border-green-400 text-green-300 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($informasi as $info)
        <div class="bg-teal rounded-xl shadow-lg p-5 border border-sky/20">

            {{-- Judul --}}
            <h2 class="text-xl font-semibold mb-2 text-gold">{{ $info->judul }}</h2>

            {{-- Gambar (Jika Ada) --}}
            @if ($info->gambar)
                <img src="{{ asset('uploads/informasi/' . $info->gambar) }}"
                     class="w-full h-40 object-cover rounded-lg mb-3">
            @endif

            {{-- Isi (dipotong 150 karakter) --}}
            <p class="text-sky mb-4">
                {{ Str::limit($info->isi, 150) }}
            </p>

            {{-- Button --}}
            <div class="flex justify-between mt-3">
                <a href="{{ route('informasi.edit', $info->id) }}"
                   class="text-sm bg-sky/20 border border-sky/40 text-sky px-3 py-1 rounded-lg hover:bg-sky/40 transition">
                   Edit
                </a>

                <a href="{{ route('informasi.delete', $info->id) }}"
                   onclick="return confirm('Yakin ingin menghapus?')"
                   class="text-sm bg-red-500/20 border border-red-400 text-red-300 px-3 py-1 rounded-lg hover:bg-red-500/40 transition">
                   Hapus
                </a>
            </div>

        </div>
    @endforeach
</div>

@endsection
