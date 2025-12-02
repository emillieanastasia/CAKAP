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
            'mapel' => 'required|string',
            'harga' => 'required|numeric',
            'tentor_id' => 'required|exists:tentors,id',
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

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kelas' => 'required|string',
            'nama_kelas' => 'required|string',
            'mapel' => 'required|string',
            'harga' => 'required|numeric',
            'tentor_id' => 'required|exists:tentors,id',
        ]);

        $kelas = Kelas::findOrFail($id);
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
