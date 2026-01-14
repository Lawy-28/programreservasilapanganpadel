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
    public function index(Request $request)
    {
        // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        $today = Carbon::today()->toDateString();

        // Mengambil input tanggal dari user (untuk filter), jika kosong default ke hari ini
        $date = $request->input('date', $today);

        // 1. Menghitung Total Booking Hari Ini
        // Mengambil jumlah reservasi yang tanggalnya hari ini dan statusnya bukan 'Batal'
        // whereDate('tanggal', $today) -> filter hanya data tanggal hari ini
        // count() -> hitung jumlah barisnya
        $totalBookingHariIni = Reservasi::whereDate('tanggal', $today)
            ->where('status_reservasi', '!=', 'Batal')
            ->count();

        // 2. Menghitung Lapangan Terpakai Saat Ini
        // Mengambil waktu sekarang (jam:menit:detik)
        $now = Carbon::now()->format('H:i:s');

        // Mengecek jumlah lapangan unik yang sedang ada reservasi pada jam sekarang
        // Logika: Tanggal harus hari ini DAN jam sekarang berada di antara jam_mulai dan jam_selesai
        // distinct('id_lapangan') -> memastikan 1 lapangan hanya dihitung 1 kali meski ada multiple booking (jarang terjadi validasi overlap bagus)
        $lapanganTerpakai = Reservasi::whereDate('tanggal', $today)
            ->where('jam_mulai', '<=', $now)
            ->where('jam_selesai', '>=', $now)
            ->where('status_reservasi', '!=', 'Batal')
            ->distinct('id_lapangan')
            ->count('id_lapangan');

        // Mengambil total semua lapangan yang tersedia di database untuk perbandingan (misal: 2 dari 4 lapangan terpakai)
        $totalLapangan = Lapangan::count();

        // 3. Menghitung Pendapatan Hari Ini
        // Menjumlahkan kolom 'total_bayar' dari semua reservasi hari ini yang sukses (tidak batal)
        $pendapatanHariIni = Reservasi::whereDate('tanggal', $today)
            ->where('status_reservasi', '!=', 'Batal')
            ->sum('total_bayar');

        // 4. Mengambil Data Reservasi Berdasarkan Tanggal yang Dipilih
        // with(['pelanggan', 'lapangan']) -> Eager loading relasi agar tidak query berulang-ulang (N+1 problem)
        // whereDate('tanggal', $date) -> Filter sesuai tanggal inputan user
        // orderBy('jam_mulai', 'asc') -> Urutkan dari jam paling pagi
        $reservasiTerbaru = Reservasi::with(['pelanggan', 'lapangan'])
            ->whereDate('tanggal', $date)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Mengirimkan semua variabel data ke view 'dashboard' agar bisa ditampilkan
        return view('dashboard', compact(
            'totalBookingHariIni',
            'lapanganTerpakai',
            'totalLapangan',
            'pendapatanHariIni',
            'reservasiTerbaru',
            'date' // Kirim tanggal terpilih agar datepicker bisa menampilkan tanggal yang sedang aktif
        ));
    }
}
