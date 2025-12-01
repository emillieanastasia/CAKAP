<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'kelas',
        'nama_kelas',
        'harga',
        'mata_pelajaran_id',
        'tentor_id',
    ];


    public function jadwal(){
        return $this->belongsToMany(JadwalKelas::class, 'kelas_id','jadwal_id');
    }
    public function mataPelajaran(){
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
    // public function siswa(){
    //     return $this->belongsToMany(Siswa::class,'kelas_siswa','kelas_id','siswa_id');
    // }


}
