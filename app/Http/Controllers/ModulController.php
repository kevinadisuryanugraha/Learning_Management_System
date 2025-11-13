<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;

class ModulController extends Controller
{
    public function index()
    {
        $modul = Modul::with(['jurusan', 'instruktur'])->orderBy('order_index', 'asc')->get();
        return view('instruktur.modul.index', compact('modul'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        $instruktur = User::whereHas('roles', function ($q) {
            $q->where('name', 'instruktur');
        })->get();

        return view('instruktur.modul.create', compact('jurusan', 'instruktur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'id_jurusan' => 'nullable|exists:jurusan,id',
            'id_member_instruktur' => 'nullable|exists:users,id',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        Modul::create($request->all());

        return redirect()->route('instruktur.modul.index')->with('success', 'Modul berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $modul = Modul::findOrFail($id);
        $jurusan = Jurusan::all();
        $instruktur = User::whereHas('roles', function ($q) {
            $q->where('name', 'instruktur');
        })->get();

        return view('instruktur.modul.edit', compact('modul', 'jurusan', 'instruktur'));
    }

    public function update(Request $request, $id)
    {
        $modul = Modul::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'id_jurusan' => 'nullable|exists:jurusan,id',
            'id_member_instruktur' => 'nullable|exists:users,id',
            'order_index' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $modul->update($request->all());

        return redirect()->route('instruktur.modul.index')->with('success', 'Modul berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Modul::findOrFail($id)->delete();
        return redirect()->route('instruktur.modul.index')->with('success', 'Modul berhasil dihapus.');
    }
}
