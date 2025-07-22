<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PosyanduController extends Controller
{
    public function tampil3()
    {
        $kegiatan = Kegiatan::all();
        $edukasi = Edukasi::all();
        return view('kegiatan.tampil3', compact('kegiatan', 'edukasi'));
    }

    public function tampil1()
    {
        $kegiatan = Kegiatan::all();
        $edukasi = Edukasi::all();
        return view('edukasi.tampil1', compact('kegiatan', 'edukasi'));
    }




    function tambah3()
    {
        return view('kegiatan.tambah3');
    }

    function tambah1()
    {
        return view('edukasi.tambah1');
    }




    public function submit3(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan hanya data yang diperlukan
        $kegiatan = new Kegiatan();
        $kegiatan->judul = $request->judul;
        $kegiatan->keterangan = $request->keterangan;

        // Periksa apakah ada file gambar yang diunggah
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('kegiatan', 'public');
            $kegiatan->foto = $path;
        }

        $kegiatan->save();

        return redirect()->route('kegiatan.tampil3')->with('success', 'Data berhasil ditambahkan.');
    }

    public function submit1(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penjelasan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan hanya data yang diperlukan
        $edukasi = new Edukasi();
        $edukasi->judul = $request->judul;
        $edukasi->penjelasan = $request->penjelasan;

        // Periksa apakah ada file gambar yang diunggah
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('edukasi', 'public');
            $edukasi->gambar = $path;
        }

        $edukasi->save();

        return redirect()->route('edukasi.tampil1')->with('success', 'Data berhasil ditambahkan.');
    }





    function edit3($id)
    {
        $kegiatan = Kegiatan::find($id);
        return view('kegiatan.edit3', compact('kegiatan'));
    }

    function edit1($id)
    {
        $edukasi = Edukasi::find($id);
        return view('edukasi.edit1', compact('edukasi'));
    }


    public function update3(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $kegiatan->judul = $request->judul;
        $kegiatan->keterangan = $request->keterangan;

        // Jika user mengupload gambar baru
        if ($request->hasFile('foto')) {
            // Hapus gambar lama jika ada
            if ($kegiatan->foto && Storage::exists('public/' . $kegiatan->foto)) {
                Storage::delete('public/' . $kegiatan->foto);
            }

            // Simpan gambar baru
            $path = $request->file('foto')->store('kegiatan', 'public');
            $kegiatan->foto = $path;
        }

        $kegiatan->save();

        return redirect()->route('kegiatan.tampil3')->with('success', 'Data berhasil diperbarui.');
    }

    public function update1(Request $request, $id)
    {
        $edukasi = Edukasi::findOrFail($id);

        $edukasi->judul = $request->judul;
        $edukasi->penjelasan = $request->penjelasan;

        // Jika user mengupload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($edukasi->gambar && Storage::exists('public/' . $edukasi->gambar)) {
                Storage::delete('public/' . $edukasi->gambar);
            }

            // Simpan gambar baru
            $path = $request->file('gambar')->store('edukasi', 'public');
            $edukasi->gambar = $path;
        }

        $edukasi->save();

        return redirect()->route('edukasi.tampil1')->with('success', 'Data berhasil diperbarui.');
    }






    public function delete3($id)
    {
        $kegiatan = Kegiatan::find($id);

        if (!$kegiatan) {
            return redirect()->back()->with('error', 'Data kegiatan tidak ditemukan.');
        }

        // Hapus file gambar jika ada dan tersimpan di folder 'storage/app/public'
        if ($kegiatan->foto && Storage::exists('public/' . $kegiatan->foto)) {
            Storage::delete('public/' . $kegiatan->foto);
        }

        $kegiatan->delete();

        return redirect()->route('kegiatan.tampil3')->with('success', 'Data kegiatan berhasil dihapus.');
    }


    public function delete1($id)
    {
        $edukasi = Edukasi::find($id);

        if (!$edukasi) {
            return redirect()->back();
        }
        if ($edukasi->gambar && file_exists(public_path('uploads/' . $edukasi->gambar))) {
            unlink(public_path('uploads/' . $edukasi->gambar));
        }
        $edukasi->delete();

        return redirect()->route('edukasi.tampil1')->with('success', 'Data kegiatan berhasil dihapus.');
    }
}
