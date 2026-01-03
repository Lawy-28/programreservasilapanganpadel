<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Pelanggan;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasi = Reservasi::with(['pelanggan', 'lapangan'])->latest()->get();
        return view('reservasi.index', compact('reservasi'));
    }

    public function create()
    {
        // Rule 1: Hanya pelanggan aktif yang bisa dipilih
        $pelanggan = Pelanggan::where('status', 'aktif')->get();
        $lapangan = Lapangan::all(); 
        return view('reservasi.create', compact('pelanggan', 'lapangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'id_lapangan' => 'required|exists:lapangan,id_lapangan',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai', // Rule 5
            'status_reservasi' => 'required|in:Booked,Selesai,Batal',
        ]);

        // Rule 1: Validasi Pelanggan Aktif (Double Check)
        $pelanggan = Pelanggan::find($request->id_pelanggan);
        if (!$pelanggan || $pelanggan->status !== 'aktif') {
            return back()->withErrors(['id_pelanggan' => 'Pelanggan tidak aktif atau tidak ditemukan.'])->withInput();
        }

        // Rule 4 & 11: Cek Tabrakan Jadwal (Overlap)
        // Abaikan reservasi yang statusnya 'Batal'
        $isOverlap = Reservasi::where('id_lapangan', $request->id_lapangan)
            ->where('tanggal', $request->tanggal)
            ->where('status_reservasi', '!=', 'Batal')
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($isOverlap) {
            return back()->withErrors(['jam_mulai' => 'Jadwal lapangan sudah terisi pada jam tersebut.'])->withInput();
        }

        // Rule 9: Hitung Total Bayar Otomatis
        $lapangan = Lapangan::findOrFail($request->id_lapangan);
        $start = Carbon::parse($request->jam_mulai);
        $end = Carbon::parse($request->jam_selesai);
        
        // Rule 6: Durasi hitung selisih jam
        $minutes = $start->diffInMinutes($end);
        $durasi_jam = $minutes / 60;
        $total_bayar = $durasi_jam * $lapangan->harga_per_jam;

        // Rule 10: Status awal biasanya Booked (walaupun di form bisa pilih)
        // Kita biarkan user memilih sesuai input form, tapi default logic aman.

        Reservasi::create([
            'id_pelanggan' => $request->id_pelanggan,
            'id_lapangan' => $request->id_lapangan,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'total_bayar' => $total_bayar,
            'status_reservasi' => $request->status_reservasi,
        ]);

        return redirect()->route('reservasi.index')
                         ->with('success', 'Reservasi berhasil dibuat. Total: Rp ' . number_format($total_bayar, 0, ',', '.'));
    }

    public function edit($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Rule 12: Jika sudah selesai, tidak boleh diedit
        if ($reservasi->status_reservasi == 'Selesai') {
            return redirect()->route('reservasi.index')
                             ->with('error', 'Reservasi yang sudah selesai tidak dapat diubah.');
        }

        $pelanggan = Pelanggan::where('status', 'aktif')->get();
        // Jika pelanggan di reservasi ini sudah tidak aktif, tetap tampilkan agar tidak error di dropdown select
        if ($reservasi->pelanggan && $reservasi->pelanggan->status !== 'aktif') {
            $pelanggan->push($reservasi->pelanggan);
        }

        $lapangan = Lapangan::all();
        return view('reservasi.edit', compact('reservasi', 'pelanggan', 'lapangan'));
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Rule 12: Prevent update if already Selesai
        if ($reservasi->status_reservasi == 'Selesai') {
             return redirect()->route('reservasi.index')
                             ->with('error', 'Reservasi yang sudah selesai tidak dapat diubah.');
        }

        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'id_lapangan' => 'required|exists:lapangan,id_lapangan',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status_reservasi' => 'required|in:Booked,Selesai,Batal',
        ]);

        // Cek Overlap (Exclude current reservation ID)
        $isOverlap = Reservasi::where('id_lapangan', $request->id_lapangan)
            ->where('tanggal', $request->tanggal)
            ->where('id_reservasi', '!=', $id) // Exclude diri sendiri
            ->where('status_reservasi', '!=', 'Batal')
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($isOverlap) {
            return back()->withErrors(['jam_mulai' => 'Jadwal lapangan bentrok dengan reservasi lain.'])->withInput();
        }

        // Hitung Ulang Total
        $lapangan = Lapangan::findOrFail($request->id_lapangan);
        $start = Carbon::parse($request->jam_mulai);
        $end = Carbon::parse($request->jam_selesai);
        $minutes = $start->diffInMinutes($end);
        $durasi_jam = $minutes / 60;
        $total_bayar = $durasi_jam * $lapangan->harga_per_jam;

        $reservasi->update([
            'id_pelanggan' => $request->id_pelanggan,
            'id_lapangan' => $request->id_lapangan,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'total_bayar' => $total_bayar,
            'status_reservasi' => $request->status_reservasi,
        ]);

        return redirect()->route('reservasi.index')
                         ->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        
        // Opsional: block delete jika sudah selesai? 
        // Sesuai requirement tidak eksplisit dilarang delete, tapi biasanya data historis disimpan.
        // Kita biarkan delete for now.

        $reservasi->delete();
        return redirect()->route('reservasi.index')
                         ->with('success', 'Reservasi berhasil dihapus.');
    }
}
