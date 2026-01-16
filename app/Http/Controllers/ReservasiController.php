<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Pelanggan;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    /**
     * Menampilkan daftar semua reservasi.
     * Mengambil data reservasi beserta relasi 'pelanggan' dan 'lapangan',
     * diurutkan dari yang terbaru.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Ambil tanggal dari request jika user memilih tanggal lain, default ke hari ini
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        // Mengambil data reservasi berdasarkan tanggal yang dipilih
        // with(['pelanggan', 'lapangan']) -> Optimasi agar tidak query berulang-ulang
        // latest() -> Urutan data dari yang paling baru dibuat
        $reservasi = Reservasi::with(['pelanggan', 'lapangan'])
            ->whereDate('tanggal', $date)
            ->latest()
            ->get();

        // Kirim data ke view index untuk ditampilkan tabelnya
        return view('reservasi.index', compact('reservasi', 'date'));
    }

    /**
     * Menampilkan formulir untuk membuat reservasi baru.
     * Hanya mengambil pelanggan dengan status 'aktif' untuk ditampilkan di pilihan.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Aturan 1: Hanya pelanggan yang statusnya 'aktif' yang bisa melakukan reservasi atau dipilih
        $pelanggan = Pelanggan::where('status', 'aktif')->get();

        // Ambil semua data lapangan untuk ditampilkan di dropdown pilihan
        $lapangan = Lapangan::all();

        // Tampilkan form create
        return view('reservasi.create', compact('pelanggan', 'lapangan'));
    }

    /**
     * Menyimpan data reservasi baru ke database.
     * Melakukan berbagai validasi bisnis:
     * 1. Pelanggan harus aktif.
     * 2. Jam selesai harus setelah jam mulai.
     * 3. Cek bentrok jadwal (overlap) dengan reservasi lain.
     * 4. Hitung total bayar otomatis berdasarkan durasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dasar dari form
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan', // Pastikan pelanggan ada di DB
            'id_lapangan' => 'required|exists:lapangan,id_lapangan',    // Pastikan lapangan ada
            'tanggal' => 'required|date',                               // Harus format tanggal valid
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',                // Aturan 5: Jam selesai harus setelah jam mulai
            'status_reservasi' => 'required|in:Booked,Selesai,Batal',   // Status harus salah satu dari 3 opsi ini
        ]);

        // Aturan 1: Validasi Tambahan untuk memastikan Pelanggan Aktif
        $pelanggan = Pelanggan::find($request->id_pelanggan);
        if (!$pelanggan || $pelanggan->status !== 'aktif') {
            return back()->withErrors(['id_pelanggan' => 'Pelanggan tidak aktif atau tidak ditemukan.'])->withInput();
        }

        // Aturan Tambahan: Cek Status Lapangan (Tidak boleh 'Perawatan')
        // Mencegah booking jika lapangan sedang maintenance
        $lapangan = Lapangan::find($request->id_lapangan);
        if ($lapangan && $lapangan->status_lapangan == 'Perawatan') {
            return back()->withErrors(['id_lapangan' => 'Lapangan sedang dalam perawatan, tidak dapat dipilih.'])->withInput();
        }

        // Aturan 4 & 11: Cek Tabrakan Jadwal (Overlap)
        // Mengecek apakah ada reservasi lain di lapangan yang sama, tanggal yang sama,
        // yang waktunya berisan dengan jam yang diminta. Status 'Batal' diabaikan.
        $isOverlap = Reservasi::where('id_lapangan', $request->id_lapangan)
            ->where('tanggal', $request->tanggal)
            ->where('status_reservasi', '!=', 'Batal')
            ->where(function ($query) use ($request) {
                // Logika overlap: (StartA < EndB) && (EndA > StartB)
                // Artinya jam booking baru dimulai SEBELUM booking lama selesai, DAN booking baru selesai SETELAH booking lama mulai
                $query->where('jam_mulai', '<', $request->jam_selesai)
                    ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists(); // Mengembalikan True jika ada yang bentrok

        // Jika bentrok, kembalikan error ke form
        if ($isOverlap) {
            return back()->withErrors(['jam_mulai' => 'Jadwal lapangan sudah terisi pada jam tersebut.'])->withInput();
        }

        // Aturan 9: Hitung Total Bayar Otomatis
        $lapangan = Lapangan::findOrFail($request->id_lapangan);

        // Konversi string jam ke objek Carbon untuk perhitungan
        $start = Carbon::parse($request->jam_mulai);
        $end = Carbon::parse($request->jam_selesai);

        // Aturan 6: Durasi dihitung dalam satuan jam (bisa desimal)
        $minutes = $start->diffInMinutes($end); // Selisih menit
        $durasi_jam = $minutes / 60;            // Konversi ke jam (misal 90 menit = 1.5 jam)

        // Total bayar = durasi * harga per jam lapangan
        $total_bayar = $durasi_jam * $lapangan->harga_per_jam;

        // Simpan data reservasi ke database
        Reservasi::create([
            'id_pelanggan' => $request->id_pelanggan,
            'id_lapangan' => $request->id_lapangan,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'total_bayar' => $total_bayar,
            'status_reservasi' => ucfirst($request->status_reservasi), // Format huruf kapital awal
        ]);

        // Berhasil, kembali ke index dengan pesan sukses
        return redirect()->route('reservasi.index')
            ->with('success', 'Reservasi berhasil dibuat. Total: Rp ' . number_format($total_bayar, 0, ',', '.'));
    }

    /**
     * Menampilkan formulir edit reservasi.
     * Mencegah edit jika reservasi sudah berstatus 'Selesai'.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        // Cari data reservasi berdasarkan ID, jika tidak ketemu akan error 404 automatically
        $reservasi = Reservasi::findOrFail($id);

        // Aturan 12: Jika sudah selesai, tidak boleh diedit
        // Mencegah perubahan data historis yang sudah valid
        if ($reservasi->status_reservasi == 'Selesai') {
            return redirect()->route('reservasi.index')
                ->with('error', 'Reservasi yang sudah selesai tidak dapat diubah.');
        }

        // Ambil data pelanggan aktif untuk opsi ganti pelanggan
        $pelanggan = Pelanggan::where('status', 'aktif')->get();

        // Jika pelanggan yang ada di reservasi ini sekarang statusnya nonaktif,
        // tetap masukkan ke dalam list pilihan agar form tidak error saat menampilkan data lama.
        // push() -> Menambahkan item ke koleksi
        if ($reservasi->pelanggan && $reservasi->pelanggan->status !== 'aktif') {
            $pelanggan->push($reservasi->pelanggan);
        }

        $lapangan = Lapangan::all();

        // Tampilkan form edit dengan data-data tersebut
        return view('reservasi.edit', compact('reservasi', 'pelanggan', 'lapangan'));
    }

    /**
     * Memperbarui data reservasi.
     * Validasi logika sama dengan store, namun pengecekan overlap mengecualikan ID reservasi ini sendiri.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Aturan 12: Mencegah update jika sudah Selesai (Double check di sisi server)
        if ($reservasi->status_reservasi == 'Selesai') {
            return redirect()->route('reservasi.index')
                ->with('error', 'Reservasi yang sudah selesai tidak dapat diubah.');
        }

        // Validasi input
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'id_lapangan' => 'required|exists:lapangan,id_lapangan',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status_reservasi' => 'required|in:Booked,Selesai,Batal',
        ]);

        // Cek Overlap (Kecuali reservasi ini sendiri)
        // where('id_reservasi', '!=', $id) penting agar jadwalnya sendiri tidak dianggap sebagai bentrokan
        $isOverlap = Reservasi::where('id_lapangan', $request->id_lapangan)
            ->where('tanggal', $request->tanggal)
            ->where('id_reservasi', '!=', $id) // ID ini dikecualikan
            ->where('status_reservasi', '!=', 'Batal')
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                    ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($isOverlap) {
            return back()->withErrors(['jam_mulai' => 'Jadwal lapangan bentrok dengan reservasi lain.'])->withInput();
        }

        // Aturan Tambahan: Cek Status Lapangan saat Update
        // Kita perlu cek ulang apakah lapangan yang dipilih (baru/lama) statusnya Perawatan
        $lapangan = Lapangan::find($request->id_lapangan);
        if ($lapangan && $lapangan->status_lapangan == 'Perawatan') {
            return back()->withErrors(['id_lapangan' => 'Lapangan sedang dalam perawatan, tidak dapat dipilih.'])->withInput();
        }

        // Hitung Ulang Total Bayar (siapa tahu pindah lapangan atau jam)
        $lapangan = Lapangan::findOrFail($request->id_lapangan);
        $start = Carbon::parse($request->jam_mulai);
        $end = Carbon::parse($request->jam_selesai);
        $minutes = $start->diffInMinutes($end);
        $durasi_jam = $minutes / 60;
        $total_bayar = $durasi_jam * $lapangan->harga_per_jam;

        // Update data di database
        $reservasi->update([
            'id_pelanggan' => $request->id_pelanggan,
            'id_lapangan' => $request->id_lapangan,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'total_bayar' => $total_bayar,
            'status_reservasi' => ucfirst($request->status_reservasi),
        ]);

        return redirect()->route('reservasi.index')
            ->with('success', 'Reservasi berhasil diperbarui.');
    }

    /**
     * Menghapus data reservasi.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Cari data yang mau dihapus
        $reservasi = Reservasi::findOrFail($id);

        // Menghapus reservasi dari database (Hard delete)
        $reservasi->delete();

        // Redirect kembali dengan pesan
        return redirect()->route('reservasi.index')
            ->with('success', 'Reservasi berhasil dihapus.');
    }
}
