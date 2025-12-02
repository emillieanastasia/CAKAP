<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Pembayaran;

use Illuminate\Http\Request;

class AdminController extends Controller{
    public function dashboard(){
        $totalSiswa = User::where('role','siswa')->count();
        $totalTentor = User::where('role','tentor')->count();
        $totalKelas = Kelas::count();
        $totalPembayaran = Pembayaran::whereMonth ('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->where('status','lunas')
                                        ->sum ('jumlah');
    return view('dashboard-admin',[
        'totalSiswa'=>$totalSiswa,
        'totalTentor'=>$totalTentor,
        'totalPembayaran'=>$totalPembayaran,
        'totalKelas'=>$totalKelas,
    ]);
    }

}