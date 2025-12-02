<?php

namespace App\Http\Controllers;

use App\Models\JadwalKelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
 public function index(Request $request)
{
    $search = $request->input('search');

    $siswas = Siswa::with('user')
        ->when($search, function ($query) use ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhere('kelas', 'like', "%{$search}%");
        })
        ->paginate(10);

    // agar saat search dihapus → kembali ke halaman 1
    if ($search) {
        $siswas->appends(['search' => $search]);
    }

    return view('siswa.index', compact('siswas', 'search'));
}




    // ========================================
    // CREATE (Form Tambah Siswa)
    // ========================================
    public function create()
    {
        return view('siswa.create');
    }

    // ========================================
    // STORE (Simpan Data Siswa Baru)
    // ========================================
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8',
            'tanggal_lahir' => 'nullable|date',
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'kelas'         => 'nullable|string',
            'status'        => 'nullable|string',
        ]);

        // 1. Simpan ke tabel users
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa', // jika ada kolom role
        ]);

        // 2. Simpan ke tabel siswa
        Siswa::create([
            'user_id'       => $user->id,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'kelas'         => $request->kelas,
            'status'        => $request->status,
        ]);

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $siswa = $user->siswa()->with('kelas')->first();

        $kelasSiswa = $siswa;

        $totalJadwal = JadwalKelas::where('kelas_id', $kelasSiswa->kelas_id)->count();

        $totalMapel = JadwalKelas::where('kelas_id', $kelasSiswa->kelas_id)
            ->distinct('mata_pelajaran_id')
            ->count('mata_pelajaran_id');

        $hariIni = strtolower(now()->format('l'));
        $mapHari = [
            'monday'    => 'Senin',
            'tuesday'   => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday'  => 'Kamis',
            'friday'    => 'Jumat',
            'saturday'  => 'Sabtu',
            'sunday'    => 'Minggu',
        ];

        $hariDb = $mapHari[$hariIni];

        $jadwalHariIni = JadwalKelas::where('kelas_id', $kelasSiswa->kelas_id)
                            ->where('hari', $hariDb)
                            ->get();

        return view('dashboard-siswa', [
            'user' => $user,
            'siswa' => $siswa,
            'totalJadwal' => $totalJadwal,
            'totalMapel' => $totalMapel,
            'kelasSiswa' => $kelasSiswa,
            'jadwalHariIni' => $jadwalHariIni
        ]);
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->user->update([
            'name' => $request->name,
        ]);

        $siswa->update([
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp'         => $request->no_hp,
            'kelas'         => $request->kelas,
            'alamat'        => $request->alamat,
            'status'        => $request->status,
        ]);

        return redirect()->route('siswa.index')
                         ->with('success', 'Profil siswa berhasil diperbarui!');
    }

    public function editProfil()
    {
        $user = auth()->user();
        $siswa = Siswa::firstOrNew(['user_id' => $user->id]);
         $kelas = \App\Models\Kelas::all();
        return view('siswa.edit-profil', compact('user', 'siswa'));
    }

    public function updateProfil(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|min:8',
        ]);

        $dataUser = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $dataUser['password'] = Hash::make($request->password);
        }

        $user->update($dataUser);

        if ($user->siswa) {
            $user->siswa->update([
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp'         => $request->no_hp,
                'alamat'        => $request->alamat,
            ]);
        }

        return redirect()->route('edit.profil')
                         ->with('success', 'Profil dan password berhasil diperbarui!');
    }
        // ========================================
    // DESTROY (Hapus Data Siswa)
    // ========================================
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus dulu user agar tidak orphan
        if ($siswa->user) {
            $siswa->user->delete();
        }

        // Hapus data siswa
        $siswa->delete();

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa berhasil dihapus!');
    }

}
