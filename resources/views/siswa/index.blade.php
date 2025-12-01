@extends('layouts.app')
@section('title','Data Siswa')

@section('content')
<div class="container mx-auto max-w-6xl p-4"> {{-- Container disamakan max-w-6xl p-4 --}}
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-5"> {{-- Margin bottom disamakan mb-5 --}}
        <div>
            <h1 class="text-2xl font-bold text-white">Data <span class="text-lightgold">Siswa</span></h1> {{-- Ukuran text-2xl --}}
            <p class="text-sky text-xs mt-1">Kelola data siswa.</p> {{-- text-xs --}}
        </div>

        <div class="mt-3 md:mt-0">
            <a href="{{ route('siswa.create') }}"
               class="inline-flex items-center gap-2 bg-gold hover:bg-lightgold text-navy font-bold px-4 py-2 text-sm rounded-lg shadow-lg shadow-gold/20 transition-all transform hover:-translate-y-1">
                <span>➕</span> Tambah Siswa
            </a>
        </div>
    </div>

    {{-- Alert Success (Jika ada) --}}
    @if ($message = Session::get('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ $message }}</span>
        </div>
    @endif

    {{-- Tabel Container --}}
    <div class="bg-teal rounded-2xl shadow-xl border border-sky/10 overflow-hidden">
        
        {{-- Search Bar Section --}}
        <form method="GET" action="{{ route('siswa.index') }}" class="p-4 bg-navy/50 border-b border-sky/10">
            <div class="flex flex-col md:flex-row justify-end items-center gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari data siswa..."
                    class="w-full md:w-56 px-3 py-1.5 rounded-lg bg-white border border-sky/30 text-sm text-navy placeholder-gray-500 focus:ring-1 focus:ring-gold focus:outline-none"
                    oninput="this.form.submit()"
                />
            </div>
            @if(request('search'))
                <p class="mt-2 text-[11px] text-sky text-right">
                    Hasil pencarian: <span class="text-gold font-semibold">“{{ request('search') }}”</span>
                </p>
            @endif
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-navy text-sky uppercase text-[11px] font-bold tracking-wider"> {{-- Header text-[11px] --}}
                    <tr>
                        <th class="py-3 px-4 text-center">No</th>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Tanggal Lahir</th>
                        <th class="py-3 px-4">No HP</th>
                        <th class="py-3 px-4">Kelas</th>
                        <th class="py-3 px-4">Alamat</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-sky/10 text-sm"> {{-- Base font text-sm --}}
                    @forelse($siswas as $siswa)
                    <tr class="hover:bg-navy/30 transition duration-200 group">

                        {{-- Kolom No --}}
                        <td class="px-4 py-2.5 text-gray-400 group-hover:text-white font-mono text-xs text-center"> {{-- Padding py-2.5 px-4 --}}
                            {{ ($siswas->currentPage() - 1) * $siswas->perPage() + $loop->iteration }}
                        </td>

                        {{-- Kolom Nama --}}
                        <td class="py-2.5 px-4">
                            <div class="font-bold text-white text-sm">{{ $siswa->user->name ?? '-' }}</div>
                        </td>

                        {{-- Kolom Tanggal Lahir --}}
                        <td class="py-2.5 px-4 text-gray-300 text-xs">
                            {{ $siswa->tanggal_lahir }}
                        </td>

                        {{-- Kolom No HP --}}
                        <td class="py-2.5 px-4 text-gray-300 text-xs">
                            {{ $siswa->no_hp }}
                        </td>

                        {{-- Kolom Kelas --}}
                        <td class="py-2.5 px-4">
                            <span class="bg-sky/10 text-sky border border-sky/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide">
                                {{ $siswa->kelas }}
                            </span>
                        </td>

                        {{-- Kolom Alamat --}}
                        <td class="py-2.5 px-4 text-gray-300 text-xs" title="{{ $siswa->alamat }}">
                            {{ Str::limit($siswa->alamat, 20) }}
                        </td>

                        {{-- Kolom Status --}}
                        <td class="py-2.5 px-4 text-center">
                            @if(strtolower($siswa->status) === 'aktif')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-500/10 text-green-400 border border-green-500/20 uppercase">
                                    <span class="w-1 h-1 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-500/10 text-red-400 border border-red-500/20 uppercase">
                                    {{ ucfirst($siswa->status) }}
                                </span>
                            @endif
                        </td>

                        {{-- Kolom Aksi --}}
                        <td class="py-2.5 px-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('siswa.edit', $siswa->id) }}" 
                                   class="bg-gold hover:bg-lightgold text-navy font-bold px-2 py-1.5 rounded shadow transition-all transform hover:-translate-y-1 flex items-center justify-center"
                                   title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>

                                {{-- Form Hapus --}}
                                <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="form-hapus-siswa m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="tombol-hapus-siswa bg-red-600 hover:bg-red-700 text-white font-bold px-2 py-1.5 rounded shadow transition-all transform hover:-translate-y-1 flex items-center justify-center"
                                            data-nama="{{ $siswa->user->name ?? '-' }}"
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
                        <td colspan="8" class="px-6 py-8 text-center text-sky/50 italic text-xs">
                            Belum ada data siswa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($siswas->hasPages())
        <div class="p-3 border-t border-sky/10 bg-teal text-xs">
            <div class="dark-pagination text-white">
                {{ $siswas->appends(['search' => request('search')])->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Style Pagination Custom --}}
<style>
    .dark-pagination nav div { color: white !important; font-size: 0.75rem; }
    .dark-pagination span[aria-current="page"] > span {
        background-color: #F5A201 !important;
        color: #013C58 !important;
        border-color: #F5A201 !important;
    }
</style>

{{-- SCRIPT SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.form-hapus-siswa').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let button = this.querySelector('.tombol-hapus-siswa');
            let nama = button.getAttribute('data-nama');

            Swal.fire({
                title: 'Hapus Siswa?',
                text: `Data siswa atas nama "${nama}" akan dihapus permanen.`,
                icon: 'warning',
                background: '#002b40', // Sesuaikan dengan warna tema
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