@extends('layouts.create-edit')
@section('title', 'Tambah Pembayaran')

@section('content')
<div class="container mx-auto max-w-2xl p-6">

    <h1 class="text-3xl font-bold text-white text-center mb-6">
        Tambah Data <span class="text-[#FFD700]">Pembayaran</span>
    </h1>

    <form id="form-pembayaran" action="{{ route('pembayaran.store') }}" method="POST"
          class="bg-[#00537A] p-8 rounded-[30px] shadow-xl border border-[#A8E8F9]/20">
        @csrf

        {{-- 1. Siswa (HANYA INI YANG DIINPUT USER) --}}
        <div class="mb-4">
            <label for="siswa_id" class="text-[#A8E8F9] font-semibold text-sm">Siswa *</label>
            <select name="siswa_id" id="siswa_id" required
                    class="w-full bg-[#00537A] border border-[#A8E8F9] text-white rounded-lg p-2">
                <option value="" disabled selected>Pilih Siswa</option>
                @foreach ($siswa as $s)
                    {{-- PERBAIKAN DISINI: Mengambil nama dari relasi user --}}
                    <option value="{{ $s->id }}">
                        {{ $s->user->name ?? $s->nama ?? 'Siswa ID: '.$s->id }}
                    </option>
                @endforeach
            </select>
            @error('siswa_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        
        <hr class="border-gray-600 my-6">

        {{-- 2. Data Otomatis (Display Only) --}}
        <h2 class="text-xl text-white font-semibold mb-4">Detail Otomatis</h2>

        <div class="mb-4">
            <label class="text-[#A8E8F9] font-semibold text-sm">Kelas Terdaftar</label>
            <p id="kelas_otomatis" class="w-full text-white bg-[#002b40] rounded-lg p-2 italic text-sm">Pilih siswa untuk melihat data...</p>
            {{-- Hidden Field untuk Foreign Key Kelas ke Controller --}}
            <input type="hidden" name="kelas_id" id="kelas_id_input" required>
            @error('kelas_id') <p class="text-red-400 text-xs mt-1">Kelas diperlukan.</p> @enderror
        </div>

        <div class="mb-4">
            <label class="text-[#A8E8F9] font-semibold text-sm">Jumlah Biaya (Otomatis) *</label>
            <p id="jumlah_otomatis" class="w-full text-[#FFD700] bg-[#002b40] rounded-lg p-2 text-lg font-bold">Rp 0</p>
            {{-- Hidden Field untuk Jumlah Pembayaran ke Controller --}}
            <input type="hidden" name="jumlah" id="jumlah_input" required>
            @error('jumlah') <p class="text-red-400 text-xs mt-1">Jumlah diperlukan.</p> @enderror
        </div>


        {{-- 3. Data Lain (Manual Input) --}}
        
        {{-- Tanggal --}}
        <div class="mb-4">
            <label class="text-[#A8E8F9] font-semibold text-sm">Tanggal Bayar *</label>
            <input type="date" name="tanggal_bayar" required value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                class="w-full bg-[#00537A] border border-[#A8E8F9] text-white rounded-lg p-2">
            @error('tanggal_bayar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Metode --}}
        <div class="mb-4">
            <label class="text-[#A8E8F9] font-semibold text-sm">Metode *</label>
            <select name="metode" required class="w-full bg-[#00537A] border border-[#A8E8F9] text-white rounded-lg p-2">
                <option value="cash" selected>Cash</option>
                <option value="transfer">Transfer</option>
                <option value="qris">QRIS</option>
            </select>
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label class="text-[#A8E8F9] font-semibold text-sm">Status *</label>
            <select name="status" required class="w-full bg-[#00537A] border border-[#A8E8F9] text-white rounded-lg p-2">
                <option value="pending" selected>Pending</option>
                <option value="lunas">Lunas</option>
                <option value="gagal">Gagal</option>
            </select>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-gold px-6 py-2 rounded-lg font-bold text-navy">Simpan</button>
        </div>

    </form>
</div>

{{-- SCRIPT AJAX UNTUK MENGAMBIL DATA OTOMATIS --}}
<script>
    document.getElementById('siswa_id').addEventListener('change', function() {
        const siswaId = this.value;
        // Pastikan route ini benar di web.php Anda
        const url = `{{ route('pembayaran.getSiswaData', ':siswaId') }}`.replace(':siswaId', siswaId);

        // Reset display fields
        document.getElementById('kelas_otomatis').textContent = 'Mengambil data...';
        document.getElementById('jumlah_otomatis').textContent = 'Rp 0';
        document.getElementById('kelas_id_input').value = '';
        document.getElementById('jumlah_input').value = '';

        if (siswaId) {
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal memuat data siswa');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update display fields
                    // Gunakan fallback jika nama kelas null
                    document.getElementById('kelas_otomatis').textContent = data.kelas_nama || 'Tidak ada kelas terhubung';
                    
                    // Format jumlah ke Rupiah
                    const formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    });
                    document.getElementById('jumlah_otomatis').textContent = formatter.format(data.total_biaya);

                    // Update hidden input fields
                    document.getElementById('kelas_id_input').value = data.kelas_id;
                    document.getElementById('jumlah_input').value = data.total_biaya;
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    document.getElementById('kelas_otomatis').textContent = 'Error: Data gagal diambil atau siswa belum punya kelas.';
                    document.getElementById('jumlah_otomatis').textContent = 'Rp 0';
                });
        }
    });
</script>
@endsection