<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MataPelajaran;

class Tentor extends Model
{
    use HasFactory;

    protected $table = 'tentor';
    public $timestamps =false;
    protected $fillable = [
        'user_id',
        'keahlian',
        'pendidikan_terakhir',
        'alamat',
        'no_hp',
        'status',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function mataPelajaran(){
        return $this->belongsTo(mataPelajaran::class,'mata_pelajaran_id','id');
    }
}
