<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $table = 'informasi'; // Karena nama tabelnya bahasa Indonesia
    protected $guarded = [];
    public $timestamps = false; // Karena di tabel Anda pakai 'dibuat_pada', bukan 'created_at' default

    // Definisikan kolom tanggal jika ingin fitur Carbon
    protected $dates = ['dibuat_pada']; 
}
