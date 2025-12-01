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

    $kelas = \App\Models\Kelas::query()
        ->when($search, function($query, $search) {
            $query->where('kelas', 'like', "%{$search}%")
                  ->orWhere('nama_kelas', 'like', "%{$search}%")
                  ->orWhere('harga', 'like', "%{$search}%");
        })
        ->paginate(10);

    return view('kelas.index', compact('kelas', 'search'));
}

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string',
            'nama_kelas' => 'required|string',
            'mapel' => 'required|string',
            'harga' => 'required|numeric',
            'tentor_id'=>'required',
        ]);

        Kelas::create([
            'kelas' => $request->kelas,
            'nama_kelas' => $request->nama_kelas,
            'mapel' => $request->mapel,
            'harga' => $request->harga,
        ]);
        Kelas::create($validated);

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $mataPelajaran = MataPelajaran::all();
        return view('kelas.edit', compact('kelas','mataPelajaran'));

    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'kelas' => 'required|string',
        //     'nama_kelas' => 'required|string',
        //     'mapel' => 'required|string',
        //     'harga' => 'required|numeric',
        // ]);

        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'kelas' => $request->kelas,
            'nama_kelas' => $request->nama_kelas,
            'mapel' => $request->mapel,
            'harga' => $request->harga,
        ]);

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
