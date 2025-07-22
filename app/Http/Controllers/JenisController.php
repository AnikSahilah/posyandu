<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    // Tampilkan semua data
    public function tampil7()
    {
        $data = Jenis::paginate(6); // tampilkan 6 per halaman
        return view('jenis.tampil7', compact('data'));
    }


    // (Optional) Tampilkan form tambah (kalau tidak pakai modal)
    public function tambah7()
    {
        return view('jenis.tambah7');
    }

    // Simpan data baru
    public function submit7(Request $request)
    {
        $request->validate([
            'jenis_imunisasi' => 'required',
            'keterangan' => 'required',
        ]);

        Jenis::create($request->all());

        return redirect()->route('jenis.tampil7')->with('success', 'Data berhasil ditambahkan');
    }

    // (Optional) Ambil data untuk form edit (kalau tidak pakai modal)
    public function edit7($id)
    {
        $data = Jenis::findOrFail($id);
        return view('jenis.edit7', compact('data'));
    }

    // Update data
    public function update7(Request $request, $id)
    {
        $request->validate([
            'jenis_imunisasi' => 'required',
            'keterangan' => 'required',
        ]);

        $jenis = Jenis::findOrFail($id);
        $jenis->update($request->all());

        return redirect()->route('jenis.tampil7')->with('success', 'Data berhasil diupdate');
    }

    // Hapus data
    public function delete7($id)
    {
        $jenis = Jenis::findOrFail($id);
        $jenis->delete();

        return redirect()->route('jenis.tampil7')->with('success', 'Data berhasil dihapus');
    }
}
