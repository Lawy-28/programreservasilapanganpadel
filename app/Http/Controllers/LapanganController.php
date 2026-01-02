<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lapangan = Lapangan::all();
        return view('lapangan.index', compact('lapangan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lapangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:50',
            'kategori' => 'required|in:VIP,Reguler',
            'harga_per_jam' => 'required|integer|min:0',
            'status_lapangan' => 'required|in:Tersedia,Perawatan',
        ]);

        Lapangan::create($validated);

        return redirect()
            ->route('lapangan.index')
            ->with('success', 'Lapangan berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Lapangan $lapangan)
    {
        // Not strictly requested but good generic method
        return view('lapangan.show', compact('lapangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lapangan $lapangan)
    {
        return view('lapangan.edit', compact('lapangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lapangan $lapangan)
    {
        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:50',
            'kategori' => 'required|in:VIP,Reguler',
            'harga_per_jam' => 'required|integer|min:0',
            'status_lapangan' => 'required|in:Tersedia,Perawatan',
        ]);

        $lapangan->update($validated);

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lapangan $lapangan)
    {
        $lapangan->delete();

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil dihapus.');
    }
}
