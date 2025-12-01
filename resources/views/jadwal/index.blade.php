@extends('layouts.app')

@section('title', 'Jadwal Kelas')

@section('content')
<div class="container mx-auto max-w-6xl p-4"> {{-- Container max-w-6xl p-4 --}}

    <div class="flex flex-col md:flex-row justify-between items-center mb-5"> {{-- Margin bottom mb-5 --}}
        <div>
            <h1 class="text-2xl font-bold text-white">Jadwal <span class="text-lightgold">Kelas</span></h1> {{-- Font size text-2xl --}}
            <p class="text-sky text-xs mt-1">Kelola Jadwal Belajar Mengajar</p> {{-- Font size text-xs --}}
        </div>
        
        <div class="mt-3 md:mt-0">
            <a href="{{ route('jadwal.create') }}" 
               class="inline-flex items-center gap-2 bg-gold hover:bg-lightgold text-navy font-bold px-4 py-2 text-sm rounded-lg shadow-lg shadow-gold/20 transition-all transform hover:-translate-y-1"> {{-- Button compact --}}
                <span>➕</span> Buat Jadwal
            </a>
        </div>
    </div>

    {{-- Alert Success --}}
    @if ($message = Session::get('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400 text-sm flex items-center gap-2"> {{-- Alert compact --}}
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ $message }}</span>
        </div>
     @endif

     {{-- Tabel Container --}}
    <div class="bg-teal rounded-2xl shadow-xl border border-sky/10 overflow-hidden"> {{-- Rounded-2xl --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-navy text-sky uppercase text-[11px] font-bold tracking-wider"> {{-- Header text-[11px] --}}
                    <tr>
                        <th class="py-3 px-4 text-center">No</th> {{-- Padding py-3 px-4 --}}
                        <th class="py-3 px-4 text-left">Hari & Waktu</th>
                        <th class="py-3 px-4 text-left">Kelas / Tingkat</th>
                        <th class="py-3 px-4 text-left">Mata Pelajaran</th>
                        <th class="py-3 px-4 text-left">Tentor Pengajar</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sky/10 text-sm"> {{-- Base font text-sm --}}
                    @forelse ($jadwal as $j)
                        <tr class="hover:bg-navy/30 transition duration-200 group">
                            {{-- NO --}}
                            <td class="px-4 py-2.5 text-gray-400 group-hover:text-white font-mono text-xs text-center"> {{-- Padding py-2.5 px-4 --}}
                                {{ $loop->iteration }}
                            </td>

                            {{-- HARI & WAKTU --}}
                            <td class="px-4 py-2.5">
                                <div class="flex flex-col gap-1">
                                    <span class="inline-block bg-[#FFD700]/10 text-[#FFD700] px-1.5 py-0.5 rounded text-[10px] font-bold border border-[#FFD700]/30 w-fit uppercase tracking-wide">
                                        {{ strtoupper($j->hari) }}
                                    </span>
                                    <div class="text-white font-mono text-xs flex items-center gap-1">
                                        <svg class="w-3 h-3 text-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    </div>
                                </div>
                            </td>

                            {{-- KELAS --}}
                            <td class="px-4 py-2.5">
                                <div class="text-white font-bold text-sm">{{ $j->kelas->nama_kelas ?? '-' }}</div>
                                <div class="text-[10px] text-sky/70 uppercase">Tingkat: {{ $j->kelas->kelas ?? '-' }}</div>
                            </td>

                            {{-- MATA PELAJARAN --}}
                            <td class="px-4 py-2.5">
                                <div class="text-white font-medium text-xs">{{ $j->mataPelajaran->nama_mapel ?? '-' }}</div>
                            </td>

                            {{-- TENTOR --}}
                            <td class="px-4 py-2.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-navy flex items-center justify-center text-[10px] font-bold text-sky border border-sky/30">
                                        {{ substr($j->tentor->user->name ?? 'T', 0, 1) }}
                                    </div>
                                    <span class="text-gray-300 text-xs">{{ $j->tentor->user->name ?? 'Tentor N/A' }}</span>
                                </div>
                            </td>

                            {{-- AKSI --}}
                            <td class="px-4 py-2.5 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('jadwal.edit', $j->id) }}" 
                                       class="bg-[#D4AF37] hover:bg-[#C5A028] text-[#002b40] font-bold px-2 py-1.5 rounded shadow transition-all transform hover:-translate-y-1 flex items-center justify-center" 
                                       title="Edit Jadwal">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST" class="form-hapus m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="tombol-hapus bg-red-500 hover:bg-red-600 text-white font-bold px-2 py-1.5 rounded shadow transition-all transform hover:-translate-y-1 flex items-center justify-center"
                                                data-hari="{{ $j->hari }}"
                                                data-mapel="{{ $j->mataPelajaran->nama_mapel ?? '-' }}"
                                                data-kelas="{{ $j->kelas->nama_kelas ?? '-' }}"
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
                            <td colspan="6" class="px-6 py-8 text-center text-sky/50 italic text-xs">
                                Belum ada jadwal kelas yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPT SWEETALERT (Logic sama, style popup disesuaikan) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.form-hapus').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let button = this.querySelector('.tombol-hapus');
            let hari = button.getAttribute('data-hari');
            let mapel = button.getAttribute('data-mapel');
            let kelas = button.getAttribute('data-kelas');

            Swal.fire({
                title: 'Hapus Jadwal?',
                html: `Jadwal <b>${mapel}</b> untuk kelas <b>${kelas}</b> pada hari <b>${hari}</b> akan dihapus.`,
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