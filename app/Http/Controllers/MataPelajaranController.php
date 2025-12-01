<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(\Illuminate\Http\Request $request)
{
    $search = $request->input('search');

    $matapelajaran = \App\Models\MataPelajaran::query()
        ->when($search, function ($query, $search) {
            // GANTI 'judul' DENGAN NAMA KOLOM ASLI DARI DATABASE ANDA
            return $query->where('nama_mapel', 'like', "%{$search}%") 
                         // GANTI 'kode_mapel' DENGAN NAMA KOLOM ASLI JUGA
                         ->orWhere('deskripsi', 'like', "%{$search}%");
        })
        ->paginate(10);

    return view('matapelajaran.index', compact('matapelajaran', 'search'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('matapelajaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajaran,nama_mapel',
            'deskripsi'  => 'nullable|string|max:500', // deskripsi bebas
        ]);

        MataPelajaran::create([
            'nama_mapel' => $request->nama_mapel,
            'deskripsi'  => $request->deskripsi,
        ]);

        return redirect()
            ->route('matapelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        return view('matapelajaran.edit', compact('mataPelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajaran,nama_mapel,' . $id,
            'deskripsi'  => 'nullable|string|max:500', // deskripsi bebas
        ]);

        $mataPelajaran = MataPelajaran::findOrFail($id);

        $mataPelajaran->update([
            'nama_mapel' => $request->nama_mapel,
            'deskripsi'  => $request->deskripsi,
        ]);

        return redirect()
            ->route('matapelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();

        return redirect()
            ->route('matapelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}
