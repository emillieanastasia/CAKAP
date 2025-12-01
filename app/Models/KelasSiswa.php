<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    // Nama tabel harus sesuai dengan tabel pivot Anda (misal: kelas_siswa)
    protected $table = 'kelas_siswa'; 

    /**
     * Relasi ke model Jadwal.
     * Setiap entri KelasSiswa terhubung ke satu Jadwal.
     */
    public function jadwal()
    {
        // Asumsi nama Foreign Key di tabel 'kelas_siswa' adalah 'jadwal_id'
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    /**
     * Relasi ke Siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}