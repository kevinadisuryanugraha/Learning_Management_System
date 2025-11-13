<?php

namespace App\Http\Controllers;

use App\Models\Submodul;
use App\Models\Modul;
use Illuminate\Http\Request;

class SubmodulController extends Controller
{
    /**
     * Tampilkan semua submodul dari satu modul.
     */
    public function index($modul_id)
    {
        $modul = Modul::with('submodul')->findOrFail($modul_id);
        return view('instruktur.submodul.index', compact('modul'));
    }

    /**
     * Simpan submodul baru.
     */
    public function store(Request $request, $modul_id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        Submodul::create([
            'modul_id' => $modul_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'order_index' => $request->order_index ?? 0,
            'is_active' => $request->is_active ?? 1,
        ]);

        return redirect()->route('instruktur.submodul.index', $modul_id)->with('success', 'Submodul berhasil ditambahkan!');
    }

    /**
     * Update data submodul.
     */
    public function update(Request $request, $id)
    {
        $submodul = Submodul::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $submodul->update($request->all());

        return back()->with('success', 'Submodul berhasil diperbarui!');
    }

    /**
     * Hapus submodul.
     */
    public function destroy($id)
    {
        $submodul = Submodul::findOrFail($id);
        $submodul->delete();

        return back()->with('success', 'Submodul berhasil dihapus!');
    }
}
