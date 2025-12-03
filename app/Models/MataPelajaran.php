<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $table = 'mata_pelajaran'; 
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_mapel', 
        'deskripsi',
    ];
    public $timestamps = false

    // Secara default, Laravel mengasumsikan primary key adalah 'id' dan incrementing.
}
