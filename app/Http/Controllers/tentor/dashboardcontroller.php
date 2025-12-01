public function dashboard()
{
    $user = Auth::user();

    return view('dashboard-tentor', [
        'totalKelas' => Kelas::where('id', $user->id)->count(),
        'totalSiswa' => Siswa::where('id', $user->id)->count(),
        'jadwalHariIni' => Jadwal::where('id', $user->id)
                                ->where('hari', now()->format('l'))
                                ->count(),
        'jadwal' => Jadwal::where('id', $user->id)->get(),
        'siswa' => Siswa::where('id', $user->id)->get(),
    ]);
}
