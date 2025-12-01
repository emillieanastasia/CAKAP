@extends('layouts.app')
@section('title', 'Data Tentor')

@section('content')
<div class="container mx-auto max-w-5xl p-4">

    <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-white">
                Data <span class="text-lightgold">Tentor</span>
            </h1>
            <p class="text-sky text-xs mt-0.5">Kelola data tentor.</p>
        </div>

        <div class="mt-2 md:mt-0">
            <a href="{{ route('tentor.create') }}" 
               class="inline-flex items-center gap-1.5 bg-gold hover:bg-lightgold text-navy font-bold px-4 py-2 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5 text-sm">
                <span>➕</span> Tambah Tentor
            </a>
        </div>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400 flex items-center gap-2 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

   <form method="GET" action="{{ route('tentor.index') }}" class="mb-4">
    <div class="flex justify-end">
        <div class="flex items-center gap-2">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Cari data tentor..."
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

    {{-- TABLE --}}
    <div class="bg-teal rounded-2xl shadow-xl border border-sky/10 overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead class="bg-navy text-sky uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="py-3 px-4 text-center">No</th>
                        <th class="py-3 px-4 text-center">Nama Lengkap</th>
                        <th class="py-3 px-4 text-center">Keahlian</th>
                        <th class="py-3 px-4 text-center">Pendidikan</th>
                        <th class="py-3 px-4 text-center">Alamat</th>
                        <th class="py-3 px-4 text-center">No HP</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-sky/10 text-xs">
                    @forelse($tentors as $t)
                    <tr class="hover:bg-navy/30 transition duration-200 group">

                        <td class="py-2 px-4 text-gray-400 group-hover:text-white font-mono">
                            {{ $loop->iteration }}
                        </td>

                        <td class="py-2 px-4">
                            <div class="font-bold text-white text-sm">{{ $t->user->name ?? '-' }}</div>
                        </td>

                        <td class="py-2 px-4">
                            <span class="text-sky font-medium bg-sky/5 px-2 py-0.5 rounded border border-sky/10 text-[10px]">
                                {{ $t->keahlian ?? '-' }}
                            </span>
                        </td>

                        <td class="py-2 px-4 text-gray-300">{{ $t->pendidikan_terakhir ?? '-' }}</td>
                        <td class="py-2 px-4 text-gray-300" title="{{ $t->alamat }}">{{ $t->alamat ?? '-' }}</td>
                        <td class="py-2 px-4 text-gray-300">{{ $t->no_hp ?? '-' }}</td>
                        <td class="py-2 px-4 text-center">
                            @if(strtolower($t->status) === 'aktif')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-500/10 text-green-400 border border-green-500/20">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-500/10 text-red-400 border border-red-500/20">
                                    {{ ucfirst($t->status) }}
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-2">
                            <div class="flex justify-center items-center gap-1.5">

                                {{-- EDIT BUTTON --}}
                                <a href="{{ route('tentor-edit', $t->id) }}" 
                                    class="inline-block bg-gold hover:bg-lightgold text-navy font-bold px-3 py-1.5 rounded-lg text-xs shadow-md transition-all transform hover:-translate-y-0.5">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M19.414 3.586a2 2 0 112.828 2.828L11.828 17H9v-2.828l10.414-10.586z" />
                                    </svg>
                                </a>

                                {{-- DELETE BUTTON --}}
                                <form action="{{ route('tentor.destroy', $t->id) }}" 
                                      method="POST" class="form-hapus">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        data-nama="{{ $t->user->name ?? '-' }}"
                                        class="tombol-hapus bg-red-600 hover:bg-red-700 text-white font-bold px-3 py-1.5 rounded-lg text-xs shadow-md transition-all transform hover:-translate-y-0.5">
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-sky/50 italic text-xs">
                            Belum ada data Tentor.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tentors->hasPages())
        <div class="p-4 border-t border-sky/10 bg-teal text-xs">
            <div class="dark-pagination text-white !important">
                {{ $tentors->links() }}
            </div>
        </div>
        @endif

    </div>
</div>

{{-- SWEETALERT DELETE --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(auth()->user()->role === 'admin')
<script>
document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let nama = this.querySelector('.tombol-hapus').getAttribute('data-nama');

        Swal.fire({
            title: 'Hapus Data?',
            text: "Tentor \"" + nama + "\" akan dihapus permanen.",
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
                form.submit();
            }
        });
    });
});
</script>
@endif
@endsection