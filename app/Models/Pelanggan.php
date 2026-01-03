<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Menentukan nama tabel (jika tidak jamak standar bahasa inggris)
    protected $table = 'pelanggan';

    // Menentukan Primary Key sesuai desain 
    protected $primaryKey = 'id_pelanggan';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'nama',
        'no_hp',
        'email',
        'status',
    ];
}