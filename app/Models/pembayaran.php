<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Siswa;
use App\Models\Kelas;

class Pembayaran extends Model{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'pembayaran';
    const UPDATED_AT =null;
    protected $primaryKey = 'id';
    public $timestamps = true;

    // Kolom-kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'siswa_id',       
        'kelas_id', 
        'jumlah',     
        'tanggal_bayar',   
        'metode',
        'status',         
    ];
    protected $with =['siswa','kelas'];

    // Relasi ke Model Siswa.
    //  Pembayaran ini dimiliki oleh satu Siswa.
    public function siswa(){
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Relasi ke Model Kelas (opsional).
    // Jika setiap pembayaran terkait dengan satu paket kelas tertentu.
    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}