@extends('layouts.app')
@section('title', 'Data Pembayaran')

@section('content')
<div class="container mx-auto max-w-6xl p-4"> {{-- Padding container dikurangi ke p-4 --}}

    <div class="flex flex-col md:flex-row justify-between items-center mb-5"> {{-- Margin bottom dikurangi --}}
        <div>
            <h1 class="text-2xl font-bold text-white">Data <span class="text-[#FFD700]">Pembayaran</span></h1> {{-- Font size h1 dikurangi ke 2xl --}}
            <p class="text-[#A8E8F9] text-xs mt-1">Kelola Data Pembayaran Siswa</p> {{-- Font size text-xs --}}
        </div>
        
        <div class="mt-3 md:mt-0">
            <a href="{{ route('pembayaran.create') }}" 
               class="inline-flex items-center gap-2 bg-gold hover:bg-lightgold text-navy font-bold px-4 py-2 text-sm rounded-lg shadow-lg shadow-gold/20 transition-all transform hover:-translate-y-1"> {{-- Button lebih kecil (py-2 px-4 text-sm) --}}
                <span>➕</span> Tambah
            </a>
        </div>
    </div>

    {{-- Alert Success --}}
    @if ($message = Session::get('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400 text-sm flex items-center gap-2"> {{-- Alert lebih kecil --}}
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ $message }}</span>
        </div>
    @endif
    
    {{-- Tabel Container --}}
    <div class="bg-[#00537A] rounded-2xl shadow-xl border border-[#A8E8F9]/10 overflow-hidden"> {{-- Rounded dikurangi ke 2xl --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#002b40] text-[#A8E8F9] uppercase text-[11px] font-bold tracking-wider"> {{-- Font header tabel diperkecil --}}
                    <tr>
                        <th class="py-3 px-4 text-center">NO</th> {{-- Padding header dikurangi --}}
                        <th class="py-3 px-4 text-left">Siswa</th>
                        <th class="py-3 px-4 text-left">Kelas</th>
                        <th class="py-3 px-4 text-right">Jumlah</th>
                        <th class="py-3 px-4 text-center">Tanggal</th>
                        <th class="py-3 px-4 text-center">Metode</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#A8E8F9]/10 text-sm"> {{-- Base font body tabel text-sm --}}
                    @forelse ($pembayaran as $p)
                    <tr class="hover:bg-[#002b40]/30 transition duration-200 group">
                        <td class="px-4 py-2.5 text-gray-400 group-hover:text-white font-mono text-xs text-center">{{ $loop->iteration }}</td> {{-- Padding cell dikurangi ke py-2.5 px-4 --}}
                        
                        {{-- Kolom Siswa --}}
                        <td class="py-2.5 px-4 font-medium text-white">{{ $p->siswa->user->name ?? $p->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</td>
                        
                        {{-- Kolom Kelas --}}
                        <td class="py-2.5 px-4 text-gray-300 text-xs">{{ $p->siswa->kelas ?? '' }} {{ $p->kelas->nama_kelas ?? '-' }}</td>
                        
                        {{-- Kolom Jumlah --}}
                        <td class="px-4 py-2.5 text-right">
                            <span class="text-[#FFD700] font-medium text-sm">
                                Rp {{ number_format($p->total_biaya_kelas,0,',','.') }}
                            </span>
                        </td>
                        
                        {{-- Kolom Tanggal --}}
                        <td class="py-2.5 px-4 text-center text-gray-300 text-xs">{{ $p->tanggal_bayar }}</td>
                        
                        {{-- Kolom Metode --}}
                        <td class="py-2.5 px-4 text-center text-gray-300 text-xs">{{ ucfirst($p->metode) }}</td>
                        
                        {{-- KOLOM STATUS --}}
                        <td class="py-2.5 px-4 text-center">
                            @php
                                $status_lower = strtolower($p->status ?? 'Gagal'); 
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide
                                @if($status_lower == 'lunas') 
                                    bg-green-500/20 text-green-400 
                                @elseif($status_lower == 'pending') 
                                    bg-yellow-500/20 text-yellow-400 
                                @else 
                                    bg-red-500/20 text-red-400 
                                @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        
                        {{-- Bagian Aksi --}}
                        <td class="py-2.5 px-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('pembayaran.edit', $p->id) }}" 
                                   class="bg-[#D4AF37] hover:bg-[#C5A028] text-[#002b40] px-2 py-1.5 rounded shadow transition-all transform hover:-translate-y-1 flex items-center justify-center"
                                   title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> {{-- Icon lebih kecil --}}
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>

                                {{-- Form Hapus --}}
                                <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST" class="form-hapus-pembayaran m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="tombol-hapus-pembayaran bg-red-500 hover:bg-red-600 text-white px-2 py-1.5 rounded shadow transition-all transform hover:-translate-y-1 flex items-center justify-center"
                                            data-siswa="{{ $p->siswa->user->name ?? $p->siswa->nama ?? 'N/A' }}"
                                            data-jumlah="{{ number_format($p->jumlah,0,',','.') }}"
                                            title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-[#A8E8F9]/50 italic text-xs">
                            Belum ada data Pembayaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPT SWEETALERT (Tidak Berubah) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.form-hapus-pembayaran').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let button = this.querySelector('.tombol-hapus-pembayaran');
            let siswa = button.getAttribute('data-siswa');
            let jumlah = button.getAttribute('data-jumlah');

            Swal.fire({
                title: 'Hapus Pembayaran?',
                text: `Data pembayaran sebesar Rp ${jumlah} atas nama siswa ${siswa} akan dihapus permanen.`,
                icon: 'warning',
                background: '#002b40',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection