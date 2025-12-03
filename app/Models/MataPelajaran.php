<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $table = 'mata_pelajaran'; 
    protected $primaryKey = 'id';
     public $timestamps = false;
    protected $fillable = [
        'nama_mapel', 
        'deskripsi',
    ];

    // Secara default, Laravel mengasumsikan primary key adalah 'id' dan incrementing.
}