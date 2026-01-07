<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama.
     * Mengambil ringkasan data seperti total booking, lapangan terpakai,
     * pendapatan harian, dan daftar reservasi terbaru.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        $today = Carbon::today()->toDateString();

        // 1. Menghitung Total Booking Hari Ini
        // Mengambil jumlah reservasi yang tanggalnya hari ini dan statusnya bukan 'Batal'
        $totalBookingHariIni = Reservasi::whereDate('tanggal', $today)
                                        ->where('status_reservasi', '!=', 'Batal')
                                        ->count();

        // 2. Menghitung Lapangan Terpakai Saat Ini
        // Mengambil waktu sekarang
        $now = Carbon::now()->format('H:i:s');
        
        // Mengecek jumlah lapangan unik yang sedang ada reservasi pada jam sekarang
        $lapanganTerpakai = Reservasi::whereDate('tanggal', $today)
                                     ->where('jam_mulai', '<=', $now)
                                     ->where('jam_selesai', '>=', $now)
                                     ->where('status_reservasi', '!=', 'Batal')
                                     ->distinct('id_lapangan')
                                     ->count('id_lapangan');
        
        // Mengambil total semua lapangan yang tersedia di database
        $totalLapangan = Lapangan::count();

        // 3. Menghitung Pendapatan Hari Ini
        // Menjumlahkan 'total_bayar' dari reservasi hari ini yang tidak dibatalkan
        $pendapatanHariIni = Reservasi::whereDate('tanggal', $today)
                                      ->where('status_reservasi', '!=', 'Batal')
                                      ->sum('total_bayar');

        // 4. Mengambil Data Reservasi Terbaru
        // Mengambil 5 reservasi terakhir beserta relasi pelanggan dan lapangan
        $reservasiTerbaru = Reservasi::with(['pelanggan', 'lapangan'])
                                     ->latest()
                                     ->take(5)
                                     ->get();

        // Mengirimkan semua data ke view 'dashboard'
        return view('dashboard', compact(
            'totalBookingHariIni', 
            'lapanganTerpakai', 
            'totalLapangan', 
            'pendapatanHariIni', 
            'reservasiTerbaru'
        ));
    }
}
