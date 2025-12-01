<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informasi;

class InformasiController extends Controller
{
    public function index()
    {
        $informasi = Informasi::orderBy('id', 'DESC')->get();

        return view('informasi.index', compact('informasi'));
    }

    public function create()
    {
        return view('informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:150',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $gambarName = null;

        // Jika ada upload gambar
        if ($request->hasFile('gambar')) {
            $gambarName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads/informasi'), $gambarName);
        }

        Informasi::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarName,
        ]);

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);

        return view('informasi.edit', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|max:150',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $gambarName = $informasi->gambar;

        // Jika gambar baru di-upload
        if ($request->hasFile('gambar')) {
            if ($gambarName && file_exists(public_path('uploads/informasi/' . $gambarName))) {
                unlink(public_path('uploads/informasi/' . $gambarName));
            }

            $gambarName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads/informasi'), $gambarName);
        }

        $informasi->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarName,
        ]);

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);

        // Hapus file gambar jika ada
        if ($informasi->gambar && file_exists(public_path('uploads/informasi/' . $informasi->gambar))) {
            unlink(public_path('uploads/informasi/' . $informasi->gambar));
        }

        $informasi->delete();

        return redirect()->route('informasi.index')->with('success', 'Informasi berhasil dihapus!');
    }
}
