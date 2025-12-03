<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{

    /*
    |----------------------------------------------------
    | FORM ABSENSI
    |----------------------------------------------------
    | $kelas_id berasal dari route: /absensi/form/{kelas_id}
    | Kita ambil semua jadwal kelas milik kelas ini,
    | lalu pilih jadwal pertama untuk sementara.
    */

    public function form($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);

        // Ambil semua jadwal dari kelas ini
        $jadwalIds = DB::table('jadwal_kelas')
            ->where('kelas_id', $kelas->id)
            ->pluck('id');

        // Ambil siswa berdasarkan jadwal
        $siswaIds = DB::table('kelas_siswa')
            ->whereIn('jadwal_id', $jadwalIds)
            ->pluck('siswa_id');

        $siswa = Siswa::whereIn('id', $siswaIds)->with('user')->get();

        // Pilih jadwal pertama
        $jadwal_kelas_id = $jadwalIds->first() ?? null;

        return view('Absensi.form', compact('kelas', 'siswa', 'jadwal_kelas_id'));
    }


    /*
    |----------------------------------------------------
    | STORE ABSENSI
    |----------------------------------------------------
    */

    public function store(Request $request)
    {
        $jadwal_kelas_id = $request->input('jadwal_kelas_id');

        if (!$jadwal_kelas_id) {
            return back()->with('error', 'ID Jadwal Kelas tidak ditemukan.');
        }

        // Ambil kelas_id yang terkait jadwal_kelas tersebut
        $kelas_id = DB::table('jadwal_kelas')
            ->where('id', $jadwal_kelas_id)
            ->value('kelas_id');

        if (!$kelas_id) {
            return back()->with('error', 'Kelas tidak ditemukan untuk jadwal ini.');
        }

        foreach ($request->status as $siswa_id => $status) {

            // Normalisasi status (mencegah error "Data truncated")
            $status = ucfirst(strtolower($status));

            // Validasi status hanya boleh: Hadir, Izin, Sakit, Alpha
            if (!in_array($status, ['Hadir', 'Izin', 'Sakit', 'Alpha'])) {
                $status = 'Alpha';
            }

            // Cek apakah absensi hari ini sudah ada
            $existing = Absensi::where('siswa_id', $siswa_id)
                ->where('jadwal_kelas_id', $jadwal_kelas_id)
                ->whereDate('tanggal', now()->toDateString())
                ->first();

            if ($existing) {
                $existing->update([
                    'status' => $status,
                ]);
            } else {
                Absensi::create([
                    'siswa_id' => $siswa_id,
                    'jadwal_kelas_id' => $jadwal_kelas_id,
                    'status' => $status,
                    'tanggal' => now(),
                ]);
            }
        }

        return redirect()->route('absensi.rekap', $kelas_id)
            ->with('success', 'Absensi berhasil disimpan.');
    }


    /*
    |----------------------------------------------------
    | REKAP ABSENSI BULANAN
    |----------------------------------------------------
    */

    public function rekap(Request $request, Kelas $kelas)
    {
        $selectedYear = $request->input('tahun', date('Y'));
        $selectedMonth = $request->input('bulan', date('m'));

        $date = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $datesInMonth = collect(range(1, $date->daysInMonth));

        // Ambil semua jadwal kelas
        $jadwalIds = DB::table('jadwal_kelas')
            ->where('kelas_id', $kelas->id)
            ->pluck('id');

        // Ambil siswa berdasarkan jadwal
        $siswaIds = DB::table('kelas_siswa')
            ->whereIn('jadwal_id', $jadwalIds)
            ->pluck('siswa_id');

        $siswa = Siswa::whereIn('id', $siswaIds)->with('user')->get();

        // Ambil absensi bulan & tahun
        $records = Absensi::whereIn('jadwal_kelas_id', $jadwalIds)
            ->whereYear('tanggal', $selectedYear)
            ->whereMonth('tanggal', $selectedMonth)
            ->get();

        // Format untuk view
        $attendanceData = [];
        foreach ($records as $r) {
            $day = Carbon::parse($r->tanggal)->day;
            $attendanceData[$r->siswa_id][$day] = ucfirst(strtolower($r->status));
        }

        return view('Absensi.index', compact(
            'kelas',
            'siswa',
            'datesInMonth',
            'selectedYear',
            'selectedMonth',
            'attendanceData'
        ));
    }


    /*
    |----------------------------------------------------
    | CETAK PRESENSI
    |----------------------------------------------------
    */

    public function cetakPresensi($kelas_id, Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $kelas = Kelas::findOrFail($kelas_id);
        $mapel = MataPelajaran::findOrFail($kelas->mata_pelajaran_id);

        // Ambil siswa
        $siswaIds = DB::table('kelas_siswa')
            ->join('jadwal_kelas', 'kelas_siswa.jadwal_id', '=', 'jadwal_kelas.id')
            ->where('jadwal_kelas.kelas_id', $kelas_id)
            ->pluck('siswa_id')
            ->unique();

        $siswa = Siswa::with('user')->whereIn('id', $siswaIds)->get();

        // Ambil absensi
        $records = DB::table('absensi')
            ->join('jadwal_kelas', 'absensi.jadwal_kelas_id', '=', 'jadwal_kelas.id')
            ->where('jadwal_kelas.kelas_id', $kelas_id)
            ->whereYear('absensi.tanggal', $tahun)
            ->whereMonth('absensi.tanggal', $bulan)
            ->select('absensi.siswa_id', 'absensi.tanggal', 'absensi.status')
            ->get();

        $attendanceData = [];
        foreach ($records as $r) {
            $day = Carbon::parse($r->tanggal)->day;
            $attendanceData[$r->siswa_id][$day] = $r->status;
        }

        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $datesInMonth = collect(range(1, $daysInMonth));

        return view('Absensi.cetak-presensi', [
            'kelas' => $kelas,
            'mata_pelajaran' => $mapel,
            'siswa' => $siswa,
            'attendanceData' => $attendanceData,
            'datesInMonth' => $datesInMonth,
            'selectedYear' => $tahun,
            'selectedMonth' => $bulan,
        ]);
    }
}
