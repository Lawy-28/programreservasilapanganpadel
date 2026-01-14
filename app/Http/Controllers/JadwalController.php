<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    /**
     * Menampilkan jadwal penggunaan lapangan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Ambil tanggal dari request jika user memilih tanggal lain, default ke hari ini
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        // Ambil semua data lapangan untuk header tabel atau grid jadwal
        $lapangan = Lapangan::all();

        // Ambil reservasi pada tanggal tersebut yang statusnya bukan Batal
        // with('pelanggan') -> ambil data nama pelanggan sekalian (Optimasi query)
        // whereDate -> memastikan data yang diambil hanya untuk hari yang dipilih
        // orderBy('jam_mulai') -> urutkan jadwal dari pagi ke malam
        $reservasi = Reservasi::with('pelanggan')
            ->whereDate('tanggal', $date)
            ->where('status_reservasi', '!=', 'Batal')
            ->orderBy('jam_mulai')
            ->get();

        // Kirim data lapangan, reservasi, dan tanggal aktif ke view 'jadwal.index'
        return view('jadwal.index', compact('lapangan', 'reservasi', 'date'));
    }
}
