<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    // Tampilkan semua data petugas
    public function tampil6()
    {
        $data = Petugas::all();
        return view('petugas.tampil6', compact('data'));
    }

    // Tampilkan form tambah petugas
    public function tambah6()
    {
        return view('petugas.tambah6');
    }

    // Simpan data petugas baru
    public function submit6(Request $request)
    {
        $request->validate([
            'nama_petugas' => 'required',
            'jabatan_petugas' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'status' => 'required|in:aktif,tidak aktif',
            'nomer_hp' => 'nullable',
        ]);

        Petugas::create($request->all());

        return redirect()->route('petugas.tampil6')->with('success', 'Data petugas berhasil ditambahkan.');
    }

    // Tampilkan form edit petugas
    public function edit6($id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('petugas.edit6', compact('petugas'));
    }

    // Update data petugas
    public function update6(Request $request, $id)
    {
        $request->validate([
            'nama_petugas' => 'required',
            'jabatan_petugas' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'status' => 'required|in:aktif,tidak aktif',
            'nomer_hp' => 'nullable',
        ]);

        $petugas = Petugas::findOrFail($id);
        $petugas->update($request->all());

        return redirect()->route('petugas.tampil6')->with('success', 'Data petugas berhasil diupdate.');
    }

    // Hapus data petugas
    public function delete6($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();

        return redirect()->route('petugas.tampil6')->with('success', 'Data petugas berhasil dihapus.');
    }
}
