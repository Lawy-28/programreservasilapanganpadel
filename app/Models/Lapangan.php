<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $table = 'lapangan';       // Menentukan nama tabel yang digunakan (defaultnya: lapangans)
    protected $primaryKey = 'id_lapangan'; // Menentukan primary key kustom (defaultnya: id)

    // Kolom-kolom yang boleh diisi secara massal (Mass Assignment)
    protected $fillable = [
        'nama_lapangan',
        'kategori',
        'harga_per_jam',
        'status_lapangan',
    ];
}

