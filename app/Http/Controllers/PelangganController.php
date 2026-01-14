<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Menampilkan halaman daftar semua pelanggan.
     * Mengambil seluruh data dari tabel 'pelanggan' dan mengirimkannya ke view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    /**
     * Menampilkan formulir untuk menambahkan pelanggan baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Menyimpan data pelanggan baru ke database.
     * Melakukan validasi input seperti nama, no_hp, email, dan status sebelum disimpan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'required|max:100',
            'no_hp' => 'required|numeric|digits_between:10,15', // Wajib angka, 10-15 digit
            'email' => 'nullable|email|max:100',      // Boleh kosong, jika ada harus format email valid
            'status' => 'required|in:aktif,nonaktif', // Hanya boleh 'aktif' atau 'nonaktif'
        ], [
            // Pesan error kustom agar lebih mudah dimengerti user
            'no_hp.numeric' => 'No HP harus berupa angka.',
            'no_hp.digits_between' => 'No HP harus antara 10 sampai 15 digit.',
        ]);

        // Simpan data ke tabel pelanggan
        Pelanggan::create($request->all());

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan.index')
            ->with('success', 'Data Pelanggan berhasil ditambahkan');
    }

    /**
     * Menampilkan formulir edit untuk mengubah data pelanggan.
     * Mencari pelanggan berdasarkan ID, jika tidak ditemukan akan menampilkan error 404.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Cari data pelanggan berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);

        // Kirim data pelanggan ke view edit
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Memperbarui data pelanggan yang ada di database.
     * Melakukan validasi yang sama dengan proses store sebelum update.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi input ulang
        $request->validate([
            'nama' => 'required|max:100',
            'no_hp' => 'required|numeric|digits_between:10,15',
            'email' => 'nullable|email|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'no_hp.numeric' => 'No HP harus berupa angka.',
        ]);

        // 2. Cari data pelanggan berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);

        // 3. Update data dengan input baru
        $pelanggan->update($request->all());

        // 4. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan.index')
            ->with('success', 'Data Pelanggan berhasil diperbarui');
    }

    /**
     * Menghapus data pelanggan dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Cari pelanggan dan hapus
        $pelanggan = Pelanggan::findOrFail($id);

        // Hapus (Hard Delete by default kecuali ada SoftDeletes)
        $pelanggan->delete();

        // Kembali dengan pesan sukses
        return redirect()->route('pelanggan.index')
            ->with('success', 'Data Pelanggan berhasil dihapus');
    }
}