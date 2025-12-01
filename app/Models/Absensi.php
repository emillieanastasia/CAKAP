<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id',
        'jadwal_kelas_id',
        'kelas_id',
        'tanggal',
        'status'
    ];

    public $timestamps = false;
}
