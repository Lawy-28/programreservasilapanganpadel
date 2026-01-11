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
        // Ambil tanggal dari request, default hari ini
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        // Ambil semua data lapangan
        $lapangan = Lapangan::all();

        // Ambil reservasi pada tanggal tersebut yang statusnya bukan Batal
        // Kita load relasi pelanggan untuk menampilkan nama booker jika perlu
        $reservasi = Reservasi::with('pelanggan')
            ->whereDate('tanggal', $date)
            ->where('status_reservasi', '!=', 'Batal')
            ->orderBy('jam_mulai')
            ->get();

        return view('jadwal.index', compact('lapangan', 'reservasi', 'date'));
    }
}
