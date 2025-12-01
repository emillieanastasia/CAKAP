<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model{
    protected $table = 'jadwal_kelas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'kelas_id',
        'mata_pelajaran_id',
        'tentor_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tentor(){
        return $this->belongsTo(Tentor::class, 'tentor_id');
    }
    public function mataPelajaran(){
        return $this->belongsTo(MataPelajaran::class,'mata_pelajaran_id');
    }
    public function siswa(){
        return $this->belongsToMany(Siswa::class,'kelas_siswa','jadwal_id','siswa_id');
    }
    public function mapel(){
    return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }


}
