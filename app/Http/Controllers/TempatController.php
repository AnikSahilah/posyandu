<?php

namespace App\Http\Controllers;

use App\Models\Tempat;
use Illuminate\Http\Request;

class TempatController extends Controller
{
    // Tampilkan semua data tempat
    public function tampil12()
    {
        $tempat = Tempat::all();
        return view('tempat.tampil12', compact('tempat'));
    }

    // Form tambah tempat
    public function tambah12()
    {
        return view('tempat.tambah12');
    }

    // Simpan data tempat baru
    public function submit12(Request $request)
    {
        $request->validate([
            'tempat_posyandu' => 'required|string|max:255',
        ]);

        Tempat::create([
            'tempat_posyandu' => $request->tempat_posyandu,
        ]);

        return redirect()->route('tempat.tampil12')->with('success', 'Data berhasil ditambahkan.');
    }

    // Form edit tempat
    public function edit12($id)
    {
        $tempat = Tempat::findOrFail($id);
        return view('tempat.edit12', compact('tempat'));
    }

    // Update data tempat
    public function update12(Request $request, $id)
    {
        $request->validate([
            'tempat_posyandu' => 'required|string|max:255',
        ]);

        $tempat = Tempat::findOrFail($id);
        $tempat->update([
            'tempat_posyandu' => $request->tempat_posyandu,
        ]);

        return redirect()->route('tempat.tampil12')->with('success', 'Data berhasil diperbarui.');
    }

    // Hapus data tempat
    public function delete12($id)
    {
        $tempat = Tempat::findOrFail($id);
        $tempat->delete();

        return redirect()->route('tempat.tampil12')->with('success', 'Data berhasil dihapus.');
    }
}
