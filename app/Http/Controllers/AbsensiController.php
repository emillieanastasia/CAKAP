<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB; 

class AbsensiController extends Controller{
    
    // PERBAIKAN: Fungsi 'form' HARUS menerima $jadwal_kelas_id, BUKAN $kelas_id, 
    // karena absensi dicatat PER JADWAL, dan tabel absensi memiliki jadwal_kelas_id.
    // Namun, jika rute Anda tetap absensi/form/{kelas_id}, Anda perlu menentukan jadwal hari ini.
    // Berdasarkan file web.php, rute Anda adalah /absensi/form/{id} yang mengarah ke {kelas_id}.
    // Saya akan tambahkan parameter untuk $jadwal_kelas_id di controller ini.
    // Untuk saat ini, saya asumsikan Anda ingin absensi untuk *semua* siswa di kelas tersebut.
    public function form($kelas_id){ // Tetap menggunakan kelas_id sesuai rute
        // Data kelas
        $kelas = Kelas::findOrFail($kelas_id);
        
        // PENTING: Anda harus menentukan jadwal kelas yang sedang berlangsung 
        // untuk mendapatkan siswa yang terdaftar di jadwal tersebut.
        // Jika tidak, Anda akan mendapatkan SEMUA siswa yang pernah terdaftar di kelas.
        // Karena tidak ada informasi jadwal saat ini (hari/jam), saya akan ambil semua siswa
        // yang terdaftar di kelas tersebut, tapi menggunakan ID Jadwal yang benar untuk pengambilan siswa.

        // 1. Ambil semua ID Jadwal ('id') dari tabel 'jadwal_kelas' yang terkait dengan Kelas ID ini.
        $jadwalIds = DB::table('jadwal_kelas')
                      ->where('kelas_id', $kelas->id)
                      ->pluck('id'); 

        // 2. Gunakan ID Jadwal tersebut untuk mencari Siswa yang terdaftar di tabel 'kelas_siswa'
        $siswaIds = DB::table('kelas_siswa')
                      ->whereIn('jadwal_id', $jadwalIds) 
                      ->pluck('siswa_id');
        
        // 3. Ambil data Siswa menggunakan ID yang ditemukan
        $siswa = Siswa::whereIn('id', $siswaIds)->get();

        // PENTING: Untuk menyimpan absensi, kita butuh jadwal_kelas_id.
        // Karena $jadwalIds adalah array, ini tidak ideal. 
        // Jika absensi untuk kelas secara umum, Anda harus tentukan satu jadwal.
        // UNTUK SEMENTARA: Kita gunakan ID jadwal pertama sebagai placeholder untuk kebutuhan form.
        $jadwal_kelas_id = $jadwalIds->first() ?? 0; 

        return view('Absensi.form', compact('kelas', 'siswa', 'jadwal_kelas_id'));
    }

// app/Http/Controllers/AbsensiController.php (Metode store)

    public function store(Request $request){
        // PERBAIKAN UTAMA: Mengganti 'kelas_id' dengan 'jadwal_kelas_id'
        $jadwal_kelas_id = $request->input('jadwal_kelas_id'); 

        // Cek jika jadwal_kelas_id valid
        if (!$jadwal_kelas_id) {
            return redirect()->back()->with('error', 'ID Jadwal Kelas tidak ditemukan.');
        }

        // KOREKSI UTAMA: Ambil Kelas ID dari Jadwal Kelas ID
        // Variabel $kelas_id harus didefinisikan sebelum digunakan untuk redirect
        $kelas_id = DB::table('jadwal_kelas')
                      ->where('id', $jadwal_kelas_id)
                      ->value('kelas_id'); // Mengambil nilai 'kelas_id' dari baris yang ditemukan

        // Pengecekan jika kelas ID ditemukan
        if (!$kelas_id) {
            return redirect()->back()->with('error', 'Kelas terkait dengan jadwal ini tidak ditemukan.');
        }

        foreach ($request->status as $siswa_id => $status) {
            // Cek apakah siswa sudah diabsen untuk tanggal ini
            $existingAbsensi = Absensi::where('siswa_id', $siswa_id)
                ->where('jadwal_kelas_id', $jadwal_kelas_id)
                ->whereDate('tanggal', now()->toDateString())
                ->first();

            if ($existingAbsensi) {
                 // Update jika sudah ada
                 $existingAbsensi->update([
                     'status' => $status,
                     'jadwal_kelas_id'=>$jadwal_kelas_id,
                 ]);
            } else {
                // Buat baru jika belum ada
                Absensi::create([
                    'siswa_id' => $siswa_id,
                    'jadwal_kelas_id' => $jadwal_kelas_id, // Gunakan kolom yang benar
                    'status' => $status,
                    'tanggal' => now()
                ]);
            }
        }

        // KOREKSI REDIRECT: Sekarang $kelas_id sudah terdefinisi
        return redirect()->route('absensi.rekap', $kelas_id)->with('success', 'Absensi berhasil disimpan/diperbarui.');
    }

    public function rekap(Request $request, Kelas $kelas){
        $selectedYear = $request->input('tahun', date('Y'));
        $selectedMonth = $request->input('bulan', date('m'));

        $daysInMonth = 0;
        $datesInMonth = collect();

        try {
            $date = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
            $daysInMonth = $date->daysInMonth; 
            $datesInMonth = collect(range(1, $daysInMonth)); 
        } catch (\Exception $e) {
            // Handle error
        }
        
        // 1. Ambil semua ID Jadwal ('id') dari tabel 'jadwal_kelas' yang terkait dengan Kelas ID ini.
        // ID ini adalah yang disimpan di kolom 'jadwal_kelas_id' pada tabel 'absensi'.
        $jadwalKelasIds = DB::table('jadwal_kelas')
                      ->where('kelas_id', $kelas->id)
                      ->pluck('id'); 

        // 2. Gunakan ID Jadwal tersebut untuk mencari Siswa yang terdaftar di tabel 'kelas_siswa'
        $siswaIds = DB::table('kelas_siswa')
                      ->whereIn('jadwal_id', $jadwalKelasIds) 
                      ->pluck('siswa_id');

        // 3. Ambil data Siswa menggunakan ID yang ditemukan (untuk rekap)
        $siswa = Siswa::whereIn('id', $siswaIds)->with('user')->get();
        $jadwal_kelas_id = $jadwalKelasIds->first() ?? 0;
        // PERBAIKAN UTAMA PENGAMBILAN ABSENSI:
        // Menggunakan kolom 'jadwal_kelas_id' dan daftar ID Jadwal yang relevan.
        $attendanceRecords = Absensi::whereIn('jadwal_kelas_id', $jadwalKelasIds) // Ganti 'jadwal_id' menjadi 'jadwal_kelas_id'
            ->whereYear('tanggal', $selectedYear)
            ->whereMonth('tanggal', $selectedMonth)
            ->get();
        
        // Memformat data absensi menjadi array yang mudah diakses di view
        $attendanceData = $attendanceRecords->groupBy('siswa_id')
            ->map(function ($dayRecords) {
                return $dayRecords->pluck('status', 'tanggal')->mapWithKeys(function ($status, $fullDate) {
                    
                    // KOREKSI: Pastikan status diubah menjadi format Title Case ('Hadir', 'Izin', dll.)
                    $standardizedStatus = ($status === 'N/A') 
                        ? 'N/A' 
                        : ucfirst(strtolower($status));
                        
                    // Kunci adalah tanggal (1-31)
                    return [Carbon::parse($fullDate)->day => $standardizedStatus];
                });
            })
            ->toArray();
            
        return view('Absensi.index',compact(
            'kelas','siswa','datesInMonth','selectedYear','selectedMonth','attendanceData','jadwal_kelas_id'
        ));
    }
    public function cetakPresensi($kelas_id, Request $request)
{
    // 1. Ambil Bulan & Tahun dari Query String (dari URL tombol Cetak)
    // Jika tidak ada parameter, default ke bulan dan tahun saat ini
    $bulan = $request->get('bulan', date('m'));
    $tahun = $request->get('tahun', date('Y'));
    
    // 2. Ambil Kelas dan Mata Pelajaran
    // Asumsi: Model Kelas, Siswa, dan MataPelajaran sudah didefinisikan dengan benar
    $kelas = Kelas::findOrFail($kelas_id);
    // Asumsi: Ada relasi belongsTo di Model Kelas ke MataPelajaran
    $mata_pelajaran = MataPelajaran::findOrFail($kelas->mata_pelajaran_id); 
    
    // 3. Ambil Data Siswa (yang ada di kelas tersebut)
    // Asumsi: Anda memiliki relasi many-to-many atau hasMany melalui tabel pivot
    // Berdasarkan file siswa.php yang Anda berikan, model Siswa tidak punya relasi kelas,
    // maka kita harus mencari siswa yang terkait dengan jadwal di kelas ini.
    
    $siswaIds = DB::table('kelas_siswa')
        ->join('jadwal_kelas', 'kelas_siswa.jadwal_id', '=', 'jadwal_kelas.id')
        ->where('jadwal_kelas.kelas_id', $kelas_id)
        ->pluck('siswa_id')
        ->unique()
        ->toArray();

    $siswa = Siswa::with('user')->whereIn('id', $siswaIds)->get(); 

    // 4. Ambil Data Absensi untuk bulan dan tahun yang dipilih
    $attendanceRecords = DB::table('absensi') 
        ->join('jadwal_kelas', 'absensi.jadwal_kelas_id', '=', 'jadwal_kelas.id')
        ->where('jadwal_kelas.kelas_id', $kelas_id)
        ->whereYear('absensi.tanggal', $tahun)
        ->whereMonth('absensi.tanggal', $bulan)
        ->select('absensi.siswa_id', 'absensi.tanggal', 'absensi.status') // Ambil kolom yang relevan
        ->get();

    // 5. Format Data Absensi menjadi array [siswa_id][hari] => status
    $attendanceData = [];
    foreach ($attendanceRecords as $record) {
        $day = Carbon::parse($record->tanggal)->day;
        // Status: H, I, S, A
        $attendanceData[$record->siswa_id][$day] = $record->status;
    }

    // 6. Tentukan tanggal-tanggal dalam bulan
    $carbonDate = Carbon::createFromDate($tahun, $bulan, 1);
    $daysInMonth = $carbonDate->daysInMonth;
    $datesInMonth = collect(range(1, $daysInMonth));

    // 7. Kirim ke View Cetak
    return view('Absensi.cetak-presensi', [
        'kelas' => $kelas,
        'mata_pelajaran' => $mata_pelajaran,
        'siswa' => $siswa,
        'attendanceData' => $attendanceData,
        'datesInMonth' => $datesInMonth,
        'year' => $tahun,
        'month' => $bulan,
        // Kirim ulang data yang diterima dari request/default
        'selectedYear' => $tahun, 
        'selectedMonth' => $bulan,
    ]);
}
}