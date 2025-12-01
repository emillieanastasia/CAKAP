@extends('layouts.create-edit')
@section('title', 'Edit Pembayaran')

@section('content')
<div class="container mx-auto max-w-2xl p-6">

    <h1 class="text-3xl font-bold text-white text-center mb-6">
        Edit <span class="text-[#FFD700]">Pembayaran</span>
    </h1>

    <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST"
        class="bg-[#00537A] p-8 rounded-[30px] shadow-xl border border-[#A8E8F9]/20">
        @csrf
        @method('PUT')

        {{-- Siswa --}}
        <div class="mb-4">
            <label class="text-[#A8E8F9] text-sm font-semibold">Siswa *</label>
            {{-- PERBAIKAN: Tambahkan class text-white ke <select> agar nilai yang dipilih terlihat --}}
            <select name="siswa_id" class="w-full bg-[#00537A] border border-[#A8E8F9] text-white p-2 rounded-lg">
                @foreach($siswa as $s)
                    <option value="{{ $s->id }}" {{ $pembayaran->siswa_id == $s->id ? 'selected' : '' }}
                        {{-- PERBAIKAN: Memastikan teks di dalam option berwarna hitam atau warna kontras di banyak browser --}}>
                        
                        {{-- PERBAIKAN: Mengambil nama siswa melalui relasi user --}}
                        {{ $s->user->name ?? $s->nama ?? 'Nama Tidak Ditemukan' }}
                        
                    </option>
                @endforeach
            </select>
            @error('siswa_id')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kelas --}}
        <div class="mb-4">
            <label class="text-[#A8E8F9] text-sm font-semibold">Kelas *</label>
            <select name="kelas_id" class="w-full bg-[#00537A] border border-[#A8E8F9] text-white p-2 rounded-lg">
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ $pembayaran->kelas_id == $k->id ? 'selected' : '' }}>
                        {{ $k->tingkat }} - {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            @error('kelas_id')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jumlah --}}
        <div class="mb-4">
            <label class="text-[#A8E8F9] text-sm font-semibold">Jumlah *</label>
            <input type="number" name="jumlah" value="{{ old('jumlah', $pembayaran->jumlah) }}"
                    class="w-full bg-[#00537A] border border-[#A8E8F9] text-white p-2 rounded-lg">
            @error('jumlah')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal --}}
        <div class="mb-4">
            <label class="text-[#A8E8F9] text-sm font-semibold">Tanggal Bayar *</label>
            <input type="date" name="tanggal_bayar" value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar) }}"
                    class="w-full bg-[#00537A] border border-[#A8E8F9] text-white p-2 rounded-lg">
            @error('tanggal_bayar')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Metode --}}
        <div class="mb-4">
            <label class="text-[#A8E8F9] text-sm font-semibold">Metode *</label>
            <select name="metode"
                    class="w-full bg-[#00537A] border border-[#A8E8F9] text-white p-2 rounded-lg">
                <option value="cash" {{ old('metode', $pembayaran->metode) == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="transfer" {{ old('metode', $pembayaran->metode) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="qris" {{ old('metode', $pembayaran->metode) == 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>
            @error('metode')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label class="text-[#A8E8F9] text-sm font-semibold">Status *</label>
            <select name="status"
                    class="w-full bg-[#00537A] border border-[#A8E8F9] text-white p-2 rounded-lg">
                <option value="pending" {{ old('status', $pembayaran->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="lunas" {{ old('status', $pembayaran->status) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="gagal" {{ old('status', $pembayaran->status) == 'gagal' ? 'selected' : '' }}>Gagal</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-gold px-6 py-2 rounded-lg font-bold text-navy">Update</button>
        </div>

    </form>
</div>
@endsection