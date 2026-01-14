<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';       // Nama tabel
    protected $primaryKey = 'id_reservasi'; // Primary key kustom

    // Daftar kolom yang bisa diisi
    protected $fillable = [
        'id_pelanggan',
        'id_lapangan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'total_bayar',
        'status_reservasi',
    ];

    // Relasi ke Pelanggan (Many to One)
    // Setiap reservasi milik satu pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi ke Lapangan (Many to One)
    // Setiap reservasi terkait dengan satu lapangan
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'id_lapangan');
    }
}
