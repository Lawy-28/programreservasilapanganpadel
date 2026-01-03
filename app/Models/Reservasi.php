<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';

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
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi ke Lapangan (Many to One)
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'id_lapangan');
    }
}
