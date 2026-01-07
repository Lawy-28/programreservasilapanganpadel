<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    /**
     * Menampilkan daftar semua lapangan yang tersedia.
     * Mengambil data dari tabel 'lapangan' dan menampilkannya di view index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $lapangan = Lapangan::all();
        return view('lapangan.index', compact('lapangan'));
    }

    /**
     * Menampilkan formulir untuk membuat lapangan baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('lapangan.create');
    }

    /**
     * Menyimpan data lapangan baru ke dalam database.
     * Validasi input sebelum penyimpanan data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:50',
            'kategori' => 'required|in:VIP,Reguler',
            'harga_per_jam' => 'required|integer|min:0',
            'status_lapangan' => 'required|in:Tersedia,Perawatan',
        ]);

        // Simpan data lapangan baru
        Lapangan::create($validated);

        // Redirect kembali dengan pesan sukses
        return redirect()
            ->route('lapangan.index')
            ->with('success', 'Lapangan berhasil ditambahkan');
    }

    /**
     * Menampilkan detail spesifik dari sebuah lapangan.
     *
     * @param  \App\Models\Lapangan  $lapangan
     * @return \Illuminate\View\View
     */
    public function show(Lapangan $lapangan)
    {
        return view('lapangan.show', compact('lapangan'));
    }

    /**
     * Menampilkan formulir untuk mengedit data lapangan.
     *
     * @param  \App\Models\Lapangan  $lapangan
     * @return \Illuminate\View\View
     */
    public function edit(Lapangan $lapangan)
    {
        return view('lapangan.edit', compact('lapangan'));
    }

    /**
     * Memperbarui data lapangan di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lapangan  $lapangan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Lapangan $lapangan)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:50',
            'kategori' => 'required|in:VIP,Reguler',
            'harga_per_jam' => 'required|integer|min:0',
            'status_lapangan' => 'required|in:Tersedia,Perawatan',
        ]);

        // Update data lapangan
        $lapangan->update($validated);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil diperbarui.');
    }

    /**
     * Menghapus data lapangan dari database.
     *
     * @param  \App\Models\Lapangan  $lapangan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Lapangan $lapangan)
    {
        // Hapus data lapangan
        $lapangan->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil dihapus.');
    }
}
