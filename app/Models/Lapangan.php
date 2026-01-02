<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $table = 'lapangan';       // 🔴 INI KUNCI UTAMA
    protected $primaryKey = 'id_lapangan';

    protected $fillable = [
        'nama_lapangan',
        'kategori',
        'harga_per_jam',
        'status_lapangan',
    ];
}

