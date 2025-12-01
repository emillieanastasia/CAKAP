@extends('layouts.create-edit')
@section('title','Absensi')
@section('content')
<div class="min-h-screen bg-[#013C58] p-3 sm:px-4 font-sans text-white">

    {{-- HEADER BLOCK: Title, Info, dan Tombol Tambah --}}
    <div class="mb-3 pb-2 border-b border-[#A8E8F9]/20">
        {{-- Row 1: Title --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-2">
            <h2 class="text-xl font-bold text-white mb-1 md:mb-0">
                <i class="fas fa-calendar-check mr-2 text-[#FFD35B]"></i> Rekap Absensi
            </h2>
        </div>

        {{-- Row 2: Informasi Kelas/Mapel --}}
        <div class="flex flex-wrap gap-x-4 gap-y-1 text-white">
            <p class="text-xs sm:text-sm font-semibold text-[#A8E8F9]">
                Mapel: <span class="text-white font-normal">{{ $mata_pelajaran->nama_mapel ?? '-' }}</span>
            </p>
            <p class="text-xs sm:text-sm font-semibold text-[#A8E8F9]">
                Kelas: <span class="text-white font-normal">{{ $kelas->nama_kelas ?? '-' }}</span>
            </p>
        </div>
    </div>
    
    {{-- Form Filter & Aksi --}}
    <form action="{{ route('absensi.rekap', $kelas->id) }}" method="GET" class="mb-4 flex flex-wrap gap-3 items-center justify-between bg-[#00537A] p-3 rounded-xl shadow-lg border border-[#A8E8F9]/10">
    
        {{-- Grup Pilih Bulan dan Tahun --}}
        <div class="flex flex-wrap gap-2">
            {{-- Pilih Bulan --}}
            <div class="flex items-center gap-1.5">
                <label for="bulan" class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10">
                    <img src="{{ asset('images/calendar.svg') }}" alt="Bulan" class="w-4 h-4 text-[#FFD35B]">
                </label>
                <select name="bulan" id="bulan" class="py-1 px-2 rounded bg-[#013C58] border border-[#A8E8F9]/30 text-white text-xs focus:ring-1 focus:ring-[#FFD35B]">
                    @php
                        $currentMonth = $selectedMonth ?? date('m');
                    @endphp
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" class="bg-[#013C58]"
                                {{ $currentMonth == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $i, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- Pilih Tahun --}}
            <div class="flex items-center gap-1.5">
                <label for="tahun" class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10">
                    <img src="{{ asset('images/calendar.svg') }}" alt="Tahun" class="w-4 h-4 text-[#FFD35B]">
                </label>
                <select name="tahun" id="tahun" class="py-1 px-2 rounded bg-[#013C58] border border-[#A8E8F9]/30 text-white text-xs focus:ring-1 focus:ring-[#FFD35B]">
                    @php
                        $currentYear = $selectedYear ?? date('Y');
                        $startYear = date('Y') - 5;
                        $endYear = date('Y') + 1;
                    @endphp
                    @for ($y = $endYear; $y >= $startYear; $y--)
                        <option value="{{ $y }}" class="bg-[#013C58]" {{ $currentYear == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            {{-- Tampilkan Rekap --}}
            <button type="submit" class="text-white rounded-lg transition p-0.5" title="Tampilkan">
                <span class="flex items-center justify-center w-7 h-7 rounded-full bg-white/10 hover:bg-white/20">
                    <img src="{{ asset('images/search.svg') }}" alt="Cari" class="w-3.5 h-3.5">
                </span>
            </button>
        </div>

        {{-- Grup Tombol Aksi --}}
        <div class="flex flex-wrap gap-1.5 mt-2 sm:mt-0">
            {{-- Tambah Absensi Hari Ini --}}
            <a href="{{ route('absensi.form', $kelas->id) }}" 
            class="text-white rounded-lg transition p-0.5" title="Tambah Absensi">
                <span class="flex items-center justify-center w-7 h-7 rounded-full bg-white/10 hover:bg-white/20">
                    <img src="{{ asset('images/plus.svg') }}" alt="Tambah" class="w-3.5 h-3.5">
                </span>
            </a>
                        
            {{-- Cetak Presensi --}}
            <a href="{{ route('absensi.cetak', ['kelas_id' => $kelas->id, 'bulan' => $currentMonth, 'tahun' => $currentYear]) }}" 
            target="_blank" 
            class="text-white rounded-lg transition p-0.5" title="Cetak">
                <span class="flex items-center justify-center w-7 h-7 rounded-full bg-white/10 hover:bg-white/20">
                    <img src="{{ asset('images/print.svg') }}" alt="Cetak" class="w-3.5 h-3.5">
                </span>
            </a>
            
            {{-- Kembali ke Dashboard --}}
            <a href="{{ route('dashboard-tentor') }}" 
            class="text-white rounded-lg transition p-0.5" title="Kembali">
                <span class="flex items-center justify-center w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-[#FFD700] font-bold text-lg">
                    &larr;
                </span>
            </a>
        </div>
    </form>

    {{-- Tabel Absensi Bulanan --}}
    @php
        if (!isset($datesInMonth)) {
            $year = $selectedYear ?? date('Y');
            $month = $selectedMonth ?? date('m');
            $daysInMonth = \Carbon\Carbon::createFromDate($year, $month, 1)->daysInMonth;
            $datesInMonth = collect(range(1, $daysInMonth));
        }
        
        if (!isset($attendanceData)) {
             $attendanceData = []; 
        }
    @endphp

    <div class="overflow-x-auto overflow-y-auto max-h-[500px] rounded-xl shadow-lg border border-[#A8E8F9]/10 custom-scroll">
        <table class="min-w-max bg-[#00537A] table-auto border-collapse text-xs">
            <thead class="bg-[#013C58] sticky top-0 z-30 shadow-md">
                <tr>
                    <!-- Sticky First Column -->
                    <th class="p-2 text-left w-[180px] border-r border-[#A8E8F9]/20 text-[#FFD35B] sticky left-0 z-40 bg-[#013C58]">
                        Nama Siswa
                    </th>

                    <!-- Kolom Tanggal -->
                    @foreach ($datesInMonth as $day)
                        @php
                            $date = \Carbon\Carbon::create($year ?? date('Y'), $month ?? date('m'), $day);
                            $isWeekend = $date->isWeekend();
                        @endphp
                        <th class="p-1.5 text-center border-l border-[#A8E8F9]/20 w-8 {{ $isWeekend ? 'bg-red-900/40 text-red-300' : 'text-white' }}">
                            {{ str_pad($day, 2, '0', STR_PAD_LEFT) }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $sw)
                    <tr class="border-b border-[#A8E8F9]/10 hover:bg-[#013C58]/50 transition duration-150">
                        <!-- Sticky Nama Siswa -->
                        <td class="p-2 font-medium border-r border-[#A8E8F9]/10 sticky left-0 bg-[#00537A] z-20 group-hover:bg-[#00537A]">
                            {{ $sw->user->name }}
                        </td>

                        <!-- Data Kehadiran -->
                        @foreach ($datesInMonth as $day)
                            @php
                                $status = $attendanceData[$sw->id][$day] ?? 'N/A'; 
                                $date = \Carbon\Carbon::create($year ?? date('Y'), $month ?? date('m'), $day);
                                $isWeekend = $date->isWeekend();
                                $statusClass = [
                                    'Hadir' => 'text-green-400 font-bold bg-green-900/20',
                                    'Izin' => 'text-yellow-400 bg-yellow-900/20',
                                    'Sakit' => 'text-indigo-400 bg-indigo-900/20',
                                    'Alpha' => 'text-red-500 font-bold bg-red-900/20',
                                    'N/A' => 'text-gray-500 bg-[#00537A]', 
                                ][$status];
                                if ($isWeekend) $statusClass = 'text-gray-500 bg-red-900/20';
                            @endphp
                            <td class="p-1 text-center border-l border-[#A8E8F9]/10 {{ $statusClass }}">
                                {{ substr($status, 0, 1) }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- KETERANGAN --}}
    <div class="mt-4 p-3 bg-[#00537A] rounded-xl shadow-lg border border-[#A8E8F9]/10">
        <h3 class="text-sm font-semibold mb-2 text-[#FFD35B] border-b border-[#A8E8F9]/20 pb-1">Keterangan</h3>
        <div class="flex flex-wrap gap-4 justify-center sm:justify-start">
            <div class="text-center flex items-center gap-1.5">
                <span class="text-green-400 font-bold text-sm">H</span>
                <span class="text-xs text-[#A8E8F9]">Hadir</span>
            </div>
            <div class="text-center flex items-center gap-1.5">
                <span class="text-yellow-400 text-sm">I</span>
                <span class="text-xs text-[#A8E8F9]">Izin</span>
            </div>
            <div class="text-center flex items-center gap-1.5">
                <span class="text-indigo-400 text-sm">S</span>
                <span class="text-xs text-[#A8E8F9]">Sakit</span>
            </div>
            <div class="text-center flex items-center gap-1.5">
                <span class="text-red-500 font-bold text-sm">A</span>
                <span class="text-xs text-[#A8E8F9]">Alpha</span>
            </div>
            <div class="text-center flex items-center gap-1.5">
                <span class="text-gray-500 text-sm">N</span>
                <span class="text-xs text-[#A8E8F9]">Kosong</span>
            </div>
        </div>
    </div>
    
</div>
@endsection