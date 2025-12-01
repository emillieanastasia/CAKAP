<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jadwal; // Pastikan model ini di-import
use App\Models\KelasSiswa; // Pastikan model ini di-import

class PembayaranController extends Controller
{
    public function index()
    {
        // 1. Eager Loading Relasi Bertingkat yang Diperlukan
        // Memuat relasi nested untuk mengakses harga kelas:
        // Pembayaran -> Siswa -> KelasSiswa -> Jadwal -> Kelas (untuk ambil harga)
        $pembayaran = Pembayaran::with([
            'siswa.kelasSiswa.jadwal.kelas', 
            'kelas', // Tetap muat relasi 'kelas' jika masih digunakan di view
            'siswa.user' // Jika ingin mengakses nama siswa dari tabel users
        ])->get();

        // 2. Map Collection untuk Menghitung Total Biaya Kelas
        $pembayaranWithTotalHarga = $pembayaran->map(function ($p) {
            $totalHargaKelas = 0;

            // Pastikan relasi siswa ada
            if ($p->siswa) {
                // Iterasi melalui semua entri KelasSiswa yang diikuti siswa
                // 'kelasSiswa' adalah relasi hasMany dari Siswa ke KelasSiswa
                foreach ($p->siswa->kelasSiswa as $kelasSiswa) {
                    // Cek apakah relasi jadwal dan kelas ada
                    if ($kelasSiswa->jadwal && $kelasSiswa->jadwal->kelas) {
                        // Tambahkan harga kelas ke total
                        $harga = $kelasSiswa->jadwal->kelas->harga ?? 0;
                        $totalHargaKelas += $harga;
                    }
                }
            }

            // Tambahkan atribut baru ke objek Pembayaran untuk digunakan di Blade
            $p->total_biaya_kelas = $totalHargaKelas;
            
            return $p;
        });

        return view('pembayaran.index', [
            'pembayaran' => $pembayaranWithTotalHarga
        ]);
    }

    // --- Metode CRUD Lainnya (Tidak Diubah) ---
    public function create()
    {
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        return view('pembayaran.create', compact('siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|integer',
            'kelas_id' => 'required|integer',
            'jumlah' => 'required|numeric',
            'tanggal_bayar' => 'required|date',
            'metode' => 'required|string',
            'status' => 'required|string',
        ]);

        Pembayaran::create([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
            'jumlah' => $request->jumlah,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode' => $request->metode,
            'status' => $request->status,
        ]);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $siswa = Siswa::all();
        $kelas = Kelas::all();

        return view('pembayaran.edit', compact('pembayaran', 'siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $pembayaran->update([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
            'jumlah' => $request->jumlah,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode' => $request->metode,
            'status' => $request->status,
        ]);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus');
    }
    public function getSiswaData($siswaId)
    {
        // Muat relasi yang diperlukan untuk menghitung total harga
        $siswa = Siswa::with(['kelasSiswa.jadwal.kelas'])->find($siswaId);

        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        $totalHargaKelas = 0;
        $kelasDetails = [];
        $kelasIds = [];

        // Hitung total harga kelas yang diikuti siswa
        foreach ($siswa->kelasSiswa as $kelasSiswa) {
            if ($kelasSiswa->jadwal && $kelasSiswa->jadwal->kelas) {
                $kelas = $kelasSiswa->jadwal->kelas;
                $harga = $kelas->harga ?? 0;
                
                $totalHargaKelas += $harga;

                // Simpan detail kelas pertama (atau semua, tergantung kebutuhan)
                // Kita akan mengirim ID kelas pertama saja ke form store untuk FK
                if (empty($kelasIds)) {
                    $kelasIds[] = $kelas->id;
                    $kelasDetails = [
                        'id' => $kelas->id,
                        'nama' => $kelas->tingkat . ' - ' . $kelas->nama_kelas
                    ];
                }
            }
        }

        return response()->json([
            // ID kelas yang akan dikirim ke form store
            'kelas_id' => $kelasIds[0] ?? null, 
            
            // Nama kelas yang akan ditampilkan di form (jika perlu)
            'kelas_nama' => $kelasDetails['nama'] ?? 'Tidak ada kelas',
            
            // Total biaya kelas
            'total_biaya' => $totalHargaKelas, 
            
            // Nama siswa dari tabel user (jika ada)
            'siswa_nama' => $siswa->user->name ?? $siswa->nama
        ]);
    }
}