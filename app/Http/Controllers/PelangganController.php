<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // Menampilkan halaman Data Pelanggan (Sesuai UI )
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    // Menampilkan Form Tambah (Sesuai UI )
    public function create()
    {
        return view('pelanggan.create');
    }

    // Menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            // Tambahkan 'numeric' di sini
            'no_hp' => 'required|numeric|digits_between:10,15', 
            'email' => 'nullable|email|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            // Pesan error custom (Opsional, agar lebih ramah)
            'no_hp.numeric' => 'No HP harus berupa angka.',
            'no_hp.digits_between' => 'No HP harus antara 10 sampai 15 digit.',
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('pelanggan.index')
                        ->with('success', 'Data Pelanggan berhasil ditambahkan');
    }
    
    // Menampilkan Form Edit dengan data yang sudah ada
    public function edit($id)
    {
        // Cari data pelanggan berdasarkan ID, jika tidak ada tampilkan error 404
        $pelanggan = Pelanggan::findOrFail($id);
        
        // Kirim data $pelanggan ke view
        return view('pelanggan.edit', compact('pelanggan'));
    }

    // Mengupdate data ke database
    public function update(Request $request, $id)
    {
        // 1. Validasi input (Sama seperti store)
        $request->validate([
            'nama' => 'required|max:100',
            // Validasi angka agar aman
            'no_hp' => 'required|numeric|digits_between:10,15', 
            'email' => 'nullable|email|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'no_hp.numeric' => 'No HP harus berupa angka.',
        ]);

        // 2. Cari dan Update
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());

        // 3. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data Pelanggan berhasil diperbarui');
    }

    // Menghapus data
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data Pelanggan berhasil dihapus');
    }
}