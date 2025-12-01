@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div class="container mx-auto max-w-5xl p-4">

    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Data <span class="text-lightgold">Kelas</span></h1>
            <p class="text-sky text-xs mt-0.5">Kelola Kelas</p>
        </div>
        
        <div class="mt-2 md:mt-0">
            <a href="{{ route('kelas.create') }}" 
               class="inline-flex items-center gap-1.5 bg-gold hover:bg-lightgold text-navy font-bold px-4 py-2 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5 text-sm">
                <span>➕</span> Tambah Kelas
            </a>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400 flex items-center gap-2 text-sm">
            <span class="block sm:inline flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ $message }}
            </span>
        </div>
     @endif

    <form method="GET" action="{{ route('kelas.index') }}" class="p-4 bg-navy border-b border-sky/10">
    <div class="flex justify-end">

        <div class="flex items-center gap-2">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Cari kelas..."
                class="w-48 px-3 py-1.5 rounded-lg bg-white border border-sky/30
                       text-navy placeholder-gray-500 focus:ring-1 focus:ring-gold focus:outline-none text-sm"
                oninput="this.form.submit()"
            />
        </div>

    </div>

    @if(request('search'))
        <p class="mt-1 text-xs text-sky text-right">
            Hasil pencarian: 
            <span class="text-gold font-semibold">“{{ request('search') }}”</span>
        </p>
    @endif
</form>
     {{-- tabel container --}}
    <div class="bg-teal rounded-2xl shadow-xl border border-sky/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-navy text-sky uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="py-3 px-4 text-center">NO</th>
                        <th class="py-3 px-4 text-center">Jenjang</th>
                        <th class="py-3 px-4 text-center">Kelas</th>
                        <th class="py-3 px-4 text-center">Harga</th>
                        <th class="py-3 px-4 text-center">Mata Pelajaran</th>
                        <th class="py-3 px-4 text-center ">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sky/10 text-xs">
                {{-- Ganti @foreach menjadi @forelse --}}
                @forelse ($kelas as $k)
                    <tr class="hover:bg-navy/30 transition duration-200 group">
                        <td class="px-4 py-2 text-gray-400 group-hover:text-white font-mono">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4">
                            <div class="text-gray-300">{{ $k->kelas }}</div>
                        </td>
                        <td class="py-2 px-4 text-gray-300">{{ $k->nama_kelas }}</td>
                        <td class="px-4 py-2">
                            <span class="text-sky font-medium bg-sky/5 px-2 py-0.5 rounded border border-sky/10 text-[10px]">
                                Rp {{ number_format($k->harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-white/80 truncate max-w-[150px] text-center" title="{{ $k->mataPelajaran->nama_mapel ?? '-' }}">
                            {{ $k->mataPelajaran->nama_mapel ?? '-' }}
                        </td>

                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center items-center gap-1.5">
                                <a href="{{ route('kelas.edit', $k->id) }}"
                                    class="bg-[#D4AF37] hover:bg-[#C5A028] text-[#002b40] font-bold px-2 py-1.5 rounded text-xs shadow transition-all transform hover:-translate-y-0.5 flex items-center justify-center"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>

                                <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" class="form-hapus m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="tombol-hapus bg-red-500 hover:bg-red-600 text-white font-bold px-2 py-1.5 rounded text-xs shadow transition-all transform hover:-translate-y-0.5 flex items-center justify-center"
                                        data-nama="{{ $k->nama_kelas }}"
                                        data-mapel="{{ $k->mataPelajaran->nama_mapel ?? '-' }}"
                                        data-tingkat="{{ $k->kelas}}"
                                        title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                        {{-- Bagian ini hanya muncul jika data kosong --}}
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-[#A8E8F9]/50 italic text-xs">
                                    Belum ada data Kelas.
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
        </div>
        @if($kelas->hasPages())
        <div class="p-3 border-t border-sky/10 bg-teal text-xs">
            <div class="dark-pagination text-white !important">
                {{ $kelas->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('input[name="search"]');

        searchInput.addEventListener('input', function () {
            if (this.value === '') {
                this.form.submit(); // kembalikan semua data otomatis
            }
        });
    });
</script>

{{-- SCRIPT SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.form-hapus').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let button = this.querySelector('.tombol-hapus');
            let nama = button.getAttribute('data-nama');
            let mapel = button.getAttribute('data-mapel');
            let tingkat = button.getAttribute('data-tingkat');

            Swal.fire({
                title: 'Hapus Kelas?',
                text: `Kelas ${mapel} untuk kelas ${nama} ${tingkat} akan dihapus permanen.`,
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