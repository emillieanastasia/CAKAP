@extends('layouts.create-edit')

@section('content')
<div class="min-h-screen bg-[#013C58] p-3 sm:px-4 font-sans text-white">

    {{-- Header Compact --}}
    <div class="mb-3 border-b border-[#A8E8F9]/20 pb-2">
        <h2 class="text-xl font-bold text-white flex items-center">
            <i class="fas fa-clipboard-list mr-2 text-[#FFD35B]"></i> Isi Absensi Kelas: {{ $kelas->nama_kelas }}
        </h2>
        <p class="text-[#A8E8F9] text-xs font-normal mt-0.5 ml-6">Tanggal: {{ now()->translatedFormat('l, d F Y') }}</p>
    </div>

    {{-- Container Compact --}}
    <div class="bg-[#00537A] p-4 rounded-xl shadow-lg border border-[#A8E8F9]/10">
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf

            {{-- Input Hidden untuk ID Jadwal Kelas --}}
            <input type="hidden" name="jadwal_kelas_id" value="{{ $jadwal_kelas_id }}"> 

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-[#013C58]">
                            <th class="px-3 py-2 text-left border-b border-[#A8E8F9]/20">Nama Siswa</th>
                            <th class="px-3 py-2 text-center border-b border-[#A8E8F9]/20 w-32 sm:w-48">Status Kehadiran</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($siswa as $s)
                        <tr class="border-b border-[#A8E8F9]/10 hover:bg-[#013C58]/50 transition duration-150">
                            <td class="px-3 py-2 font-medium align-middle">{{ $s->user->name }}</td> 
                            <td class="px-3 py-2 text-center">
                                <select name="status[{{ $s->id }}]" class="w-full text-black px-2 py-1 rounded bg-gray-200 border border-gray-400 focus:outline-none focus:ring-1 focus:ring-[#FFD35B] text-xs cursor-pointer hover:bg-white transition">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Alpha">Alpha</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="mt-4 flex items-center">
                <button type="submit" class="bg-[#FFD35B] hover:bg-yellow-500 text-[#013C58] font-bold px-4 py-2 rounded shadow-md transition text-sm flex items-center">
                    <i class="fas fa-save mr-1.5"></i> Simpan
                </button>
                <a href="{{ route('absensi.rekap', $kelas->id) }}" class="ml-4 text-[#A8E8F9] hover:text-white transition text-xs sm:text-sm font-medium">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection