<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Tentor; // Pastikan Model Tentor ada

class JadwalController extends Controller
{
    // Menampilkan halaman Index
    public function index(){
        $jadwal = Jadwal::with(['kelas', 'mataPelajaran', 'tentor.user'])->get();
        return view('jadwal.index', compact('jadwal'));
    }

    // Menampilkan Form Tambah (Create)
    public function create(){
        $kelas = Kelas::all()->unique(function($item){
            return $item->kelas.$item->nama_kelas;
        });
        $mataPelajaran = MataPelajaran::all();
        $tentor = Tentor::with('user')->get();

        return view('jadwal.create', compact('kelas', 'mataPelajaran', 'tentor'));
    }

    // Menyimpan Data Baru (Store)
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai', // Jam selesai harus setelah jam mulai
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tentor_id' => 'required|exists:tentor,id', // Sesuaikan nama tabel tentor
        ]);

        Jadwal::create([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'tentor_id' => $request->tentor_id,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dibuat');
    }

    // Menampilkan Form Edit
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $kelas = Kelas::all();
        $mataPelajaran = MataPelajaran::all();
        $tentor = Tentor::all();

        return view('jadwal.edit', compact('jadwal', 'kelas', 'mataPelajaran', 'tentor'));
    }

    // Memperbarui Data (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tentor_id' => 'required|exists:tentor,id',
        ]);

        $jadwal = Jadwal::findOrFail($id);

        $jadwal->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'tentor_id' => $request->tentor_id,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    // Menghapus Data (Destroy)
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
}