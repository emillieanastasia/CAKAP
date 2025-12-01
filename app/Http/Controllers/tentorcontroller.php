<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tentor;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\JadwalKelas;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;

class TentorController extends Controller

{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $tentors = Tentor::with('user')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->paginate(10);

        return view('tentor.index', compact('tentors', 'search'));
    }

    public function dashboard()
    {
        $tentorId = Auth::id();
        // total kelas
        $totalKelas = Kelas::where('tentor_id', $tentorId)->count();
        // jadwal hari ini
        $hariIni = now()->format('l');
        $jadwalHariIni = JadwalKelas::where('tentor_id', $tentorId)
            ->where('hari', $hariIni)
            ->count();
        $jadwal = JadwalKelas::where('tentor_id', $tentorId)->get();

        return view('dashboard-tentor', compact(
            'totalKelas',
            'jadwalHariIni',
            'jadwal'
        ));
    }

    public function create(){
        $mataPelajaran = MataPelajaran::all();
        return view('tentor.create', compact('mataPelajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // validasi input user
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            // validasi input tentor
            'keahlian' => 'nullable|string|max:100',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        return DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'tentor'
            ]);

            Tentor::create([
                'user_id' => $user->id,
                'keahlian' => $request->keahlian,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('tentor')
                ->with('success', 'Tentor baru berhasil ditambahkan dan dihubungkan!');
        });
    }

    public function edit($id)
    {
        $tentor = Tentor::with('user')->findOrFail($id);
        $mataPelajaran = \App\Models\MataPelajaran::all();
        return view('tentor.edit', compact('tentor','mataPelajaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keahlian' => 'required|string|max:100',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        $tentor = Tentor::findOrFail($id);

        $tentor->update([
            'keahlian' => $request->keahlian,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('tentor')
            ->with('success', 'Data tentor berhasil diperbarui.');
    }

    public function editSelf()
    {
        $tentor = Tentor::where('user_id', Auth::id())->firstOrFail();
        return view('tentor.self-edit', compact('tentor'));
    }

    public function updateSelf(Request $request)
    {
        $request->validate([
            'keahlian' => 'required|string|max:100',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $tentor = Tentor::where('user_id', Auth::id())->firstOrFail();

        $tentor->update([
            'keahlian' => $request->keahlian,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()
            ->route('dashboard-tentor')
            ->with('success', 'Profil tentor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tentor = Tentor::findOrFail($id);
        $tentor->delete();

        return redirect()
            ->route('tentor')
            ->with('success', 'Data tentor berhasil dihapus.');
    }
}
