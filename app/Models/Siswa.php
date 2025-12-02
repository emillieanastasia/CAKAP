<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tanggal_lahir',
        'no_hp',
        'kelas',
        'alamat',
        'status',
    ];

    // Relasi ke user (optional kalau kamu punya tabel users)
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function pembayaran (){
        return $this->hasMany(pembayaran::class);
    }
    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function jadwal()
    {
        return $this->belongsToMany(Jadwal::class, 'kelas_siswa', 'siswa_id', 'jadwal_id')
                    ->withPivot('tentor_id') // kalau kamu ingin simpan tentor_id di pivot
                    ->withTimestamps();
    }

    public function kelasSiswa(){
        return $this->hasMany(KelasSiswa::class,'siswa_id');
    }
}
