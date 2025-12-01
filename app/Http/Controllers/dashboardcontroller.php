<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tentor;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Tambahkan ini untuk manipulasi tanggal

class DashboardController extends Controller{
    public function index(){
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('dashboard-admin');
            case 'tentor':
                return redirect()->route('dashboard-tentor');
            case 'siswa':
                return redirect()->route('dashboard-siswa');
            default:
                abort(403);
        }
        $informasi = \App\Models\Informasi::orderBy('dibuat_pada', 'DESC')->get();
        return view('dashboard-siswa', compact('informasi'));
    }
    public function dashboardAdmin() {
        $totalSiswa = Siswa::count();
        $totalTentor = Tentor::count();
        $totalKelas = Kelas::count();
        
        // Menggunakan Model Pembayaran agar konsisten
        // Hanya menghitung yang statusnya 'lunas' atau 'Lunas' (sesuaikan case sensitive database Anda)
        $totalPembayaran = Pembayaran::where('status', 'lunas')->sum('jumlah');

        return view('dashboard-admin', compact(
            'totalSiswa', 'totalTentor', 'totalKelas', 'totalPembayaran'
        ));
    }


    public function dashboardSiswa(){
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        // Mapping hari Indonesia
        $hariInggris = now()->format('l');
        $mapHari = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];
        $hariIni = $mapHari[$hariInggris];

        // Kalau siswa belum memilih kelas sama sekali
        if (!$siswa) {
            return view('dashboard-siswa', [
                'totalJadwal'   => 0,
                'totalMapel'    => 0,
                'jadwalHariIni' => collect(),
                'jadwalDiambil' => collect(), 
                'user'          => $user,
                'siswa'         => null
            ]);
        }

        // Ambil semua jadwal yang sudah diambil siswa
        $jadwalHariIni = $siswa->jadwal()
            ->with(['kelas','mataPelajaran','tentor.user'])
            ->where('hari','$hariIni')
            ->get();
            
        $jadwalDiambil = $siswa->jadwal()
        ->with(['kelas','mataPelajaran','tentor.user'])
        ->paginate(9);

        // Hitung total jadwal & mapel
        $totalJadwal = $jadwalDiambil->count();
        $totalMapel  = $jadwalDiambil->pluck('mataPelajaran.id')->unique()->count();

        // Ambil jadwal hari ini langsung dari DB
        $jadwalHariIni = $siswa->jadwal()
            ->with(['kelas','mataPelajaran','tentor.user'])
            ->where('hari', $hariIni)
            ->get();

        return view('dashboard-siswa', [
            'totalJadwal'   => $totalJadwal,
            'totalMapel'    => $totalMapel,
            'jadwalHariIni' => $jadwalHariIni,
            'jadwalDiambil' => $jadwalDiambil,
            'user'          => $user,
            'siswa'         => $siswa,
        ]);
    }

    public function rincianKelas($id){
        // id = id jadwal_kelas
        $jadwalKelas = Jadwal::with(['mapel', 'kelas', 'tentor.user'])->findOrFail($id);
        // $jadwalKelas = Jadwal::findOrFail($id);

        // Temukan siswa melalui jadwal_id
        $siswa = Siswa::whereHas('jadwal', function($q) use ($id) {
            $q->where('jadwal_kelas.id', $id);
        })->get();
        $siswa->load('user');

        return view('siswa.rincian-kelas', compact('siswa', 'jadwalKelas'));
    }

    // Daftar Kelas
    public function pilihKelas(){
        $jadwal = Jadwal::with(['kelas', 'mataPelajaran', 'tentor'])
                    ->withCount('siswa')
                    ->orderBy('hari', 'asc')
                    ->orderBy('jam_mulai', 'asc')
                    ->paginate(10);
        $siswa = auth()->user()->siswa;
        $jadwal_diikuti = $siswa->jadwal()->pluck('jadwal_id')->toArray();

        return view('siswa.pilih-kelas', compact('jadwal','jadwal_diikuti'));
    }

    public function storeKelas(Request $request){

            $request->validate([
                'jadwal_id' => 'required|exists:jadwal_kelas,id',
                'tentor_id' => 'required|exists:tentor,id',
            ]);

            $user = auth()->user();
            $siswa = Siswa::where('user_id', $user->id)->first(); 
            
            if (!$siswa) {
                return back()->with('error','Data siswa tidak ditemukan.');
            }

            $jadwal_id = $request->jadwal_id;
            $max_capacity = 20; // Kapasitas Maksimal Kelas

            // Muat jadwal dan hitungan siswa saat ini
            $jadwal = Jadwal::with(['kelas', 'mataPelajaran'])
                            ->withCount('siswa')
                            ->findOrFail($jadwal_id);

            // Pengecekan 1: Sudah bergabung?
            if ($siswa->jadwal()->where('jadwal_kelas.id', $jadwal_id)->exists()) {
                $pesan_error = "Anda sudah terdaftar di kelas **"
                                . $jadwal->mataPelajaran->nama_mapel
                                . "** untuk jenjang **"
                                . $jadwal->kelas->nama_kelas
                                . "**. Silakan cek daftar kelas Anda.";
                return back()->with('error', $pesan_error);
            }

            // Pengecekan 2: Apakah kelas sudah penuh?
            if ($jadwal->siswa_count >= $max_capacity) {
                $pesan_error = "Kelas **"
                            . $jadwal->mataPelajaran->nama_mapel
                            . "** ("
                            . $jadwal->kelas->nama_kelas
                            . ") sudah mencapai kapasitas maksimal ("
                            . $max_capacity . " siswa). Silakan pilih jadwal lain.";
                return back()->with('error', $pesan_error);
            }
            
            // Gabung Kelas
            $siswa->jadwal()->attach($jadwal->id, [
                'tentor_id' => $request->tentor_id
            ]);

            $pesan = "Kelas "
                    . $jadwal->mataPelajaran->nama_mapel
                    . " untuk jenjang "
                    . $jadwal->kelas->nama_kelas
                    . "telah ditambahkan di daftar Kelas Saya.";

            return redirect()
            ->route('dashboard-siswa')
            ->withFragment('kelas-diikuti')
            ->with('success', $pesan);
        }

    public function destroyKelas($jadwal_id){
        $siswa = auth()->user()->siswa; 

        if (!$siswa) {
            return back()->with('error','Data siswa tidak ditemukan.');
        }

        // Muat jadwal dan informasinya
        $jadwal = Jadwal::with(['kelas', 'mataPelajaran'])->findOrFail($jadwal_id);

        // Detach (hapus) relasi dari tabel pivot
        $detached = $siswa->jadwal()->detach($jadwal_id); // Menggunakan detach() untuk many-to-many

        if ($detached) {
            $pesan = "Anda berhasil meninggalkan kelas "
                    . $jadwal->mataPelajaran->nama_mapel
                    . "("
                    . $jadwal->kelas->nama_kelas
                    . ").";
            return redirect()
                ->route('dashboard-siswa')
                ->withFragment('kelas-diikuti')
                ->with('success', $pesan);
        } else {
            return back()->with('error', 'Gagal meninggalkan kelas. Kelas mungkin sudah tidak diikuti.');
        }
    }

    public function dashboardTentor(){
    $user = Auth::user();

    $tentor = Tentor::with('mataPelajaran')->where('user_id', $user->id)->first();

    // Mapping hari
    $hariInggris = now()->format('l');
    $mapHari = [
        'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
    ];
    $hariIni = $mapHari[$hariInggris];

    if (!$tentor) {
        return view('dashboard-tentor', [
            'totalKelas'    => 0,
            'totalSiswa'    => 0,
            'jadwalHariIni' => collect(),
            'jadwal'        => collect(),
            'tentor'        => null,
        ]);
    }

    // 1️⃣ Ambil semua jadwal_id yang diampu oleh tentor berdasarkan kelas_siswa
    $jadwalIds = DB::table('kelas_siswa')
                    ->where('tentor_id', $tentor->id)
                    ->pluck('jadwal_id')
                    ->unique();

    // 2️⃣ Hitung Total Kelas = jumlah jadwal unik yang diampu
    $totalKelas = $jadwalIds->count();

    // 3️⃣ Hitung total siswa yang mengambil jadwal tentor ini
    $totalSiswa = DB::table('kelas_siswa')
                    ->where('tentor_id', $tentor->id)
                    ->distinct('siswa_id')
                    ->count('siswa_id');

    // 4️⃣ Ambil detail semua jadwal berdasarkan jadwal_id
    $jadwal = Jadwal::with(['kelas', 'mataPelajaran'])
                    ->whereIn('id', $jadwalIds)
                    ->orderBy('hari', 'asc')
                    ->orderBy('jam_mulai', 'asc')
                    ->get();

    // 5️⃣ Filter jadwal hari ini
    $jadwalHariIni = $jadwal->where('hari', $hariIni);

    return view('dashboard-tentor', [
        'user'=>$user,
        'totalKelas'    => $totalKelas,
        'totalSiswa'    => $totalSiswa,
        'jadwalHariIni' => $jadwalHariIni,
        'jadwal'        => $jadwal,
        'tentor'        => $tentor,
        'mapelDiajar'=>$mapelDiajar??collect(),
    ]);
    }
    public function editProfil(){
        $user = Auth::user();

        // 1. Ambil data Tentor yang sedang login
        $tentor = Tentor::where('user_id', $user->id)->firstOrFail();

        // 2. Ambil SEMUA data Mata Pelajaran (untuk dropdown)
        // Pastikan Anda memiliki Model MataPelajaran yang terhubung ke tabel mata_pelajaran
        $mataPelajaran = MataPelajaran::all(); 

        // 3. Lewatkan SEMUA variabel ke view
        return view('tentor.edit-profil', compact('user', 'tentor', 'mataPelajaran'));
    }
    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $tentor = \App\Models\Tentor::where('user_id', $user->id)->firstOrFail();

        // 1. Validasi Input
        $request->validate([
            // USERS TABLE
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // Ditambahkan: Validasi Password
            
            // TENTOR TABLE
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id', // Ditambahkan
            'pendidikan_terakhir' => 'required|string|max:100', // Ditambahkan
            'no_hp' => 'nullable|string|max:20', // DIUBAH dari 'no_telp' menjadi 'no_hp'
            'alamat' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Update Model User
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        // Cek dan HASH Password jika diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData); // Lakukan update untuk model User

        // 3. Update Model TENTOR
        $tentorData = [
            'mata_pelajaran_id' => $request->mata_pelajaran_id, // Ditambahkan
            'pendidikan_terakhir' => $request->pendidikan_terakhir, // Ditambahkan
            'no_hp' => $request->no_hp, // DIUBAH menjadi no_hp
            'alamat' => $request->alamat,
        ];
        $tentor->update($tentorData);
        return redirect()->route('dashboard-tentor')->with('success', 'Profil berhasil diperbarui!');
    }
}
