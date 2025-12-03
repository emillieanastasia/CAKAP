<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Tentor;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kelas = Kelas::query()
            ->when($search, function ($query, $search) {
                $query->where('kelas', 'like', "%{$search}%")
                      ->orWhere('nama_kelas', 'like', "%{$search}%")
                      ->orWhere('harga', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('kelas.index', compact('kelas', 'search'));
    }

    public function create()
    {
        $mataPelajaran = MataPelajaran::all();
        $tentor = Tentor::all();

        return view('kelas.create', compact('mataPelajaran', 'tentor'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|string',
            'nama_kelas' => 'required|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id', 
            'harga' => 'required|numeric',
            
            // REVISI: Mengubah 'tentors' menjadi 'tentor' untuk konsistensi dengan metode update
            'tentor_id' => 'required|exists:tentor,id', 
        ]);

        Kelas::create($validated);

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $mataPelajaran = MataPelajaran::all();
        $tentor = Tentor::all();

        return view('kelas.edit', compact('kelas', 'mataPelajaran', 'tentor'));
    }

    /**
     * Metode Update yang Sudah Direvisi.
     */
    public function update(Request $request, $id)
    {
        // Validasi ini sudah benar dan menggunakan 'tentor'
        $validated = $request->validate([
            'kelas' => 'required|string',
            'nama_kelas' => 'required|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id', 
            'harga' => 'required|numeric',
            'tentor_id' => 'required|exists:tentor,id', 
        ]);

        $kelas = Kelas::findOrFail($id);
        
        // Pastikan model Kelas memiliki kolom-kolom ini di properti $fillable!
        $kelas->update($validated);

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus');
    }
}