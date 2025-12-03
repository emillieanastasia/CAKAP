<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'mata_pelajaran'; 
    
    // Kunci utama (primary key)
    protected $primaryKey = 'id';
    
    // Menonaktifkan kolom created_at dan updated_at
    public $timestamps = false; // <-- CORRECT: Semicolon is present here
    
    // Kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'nama_mapel', 
        'deskripsi',
    ];
}