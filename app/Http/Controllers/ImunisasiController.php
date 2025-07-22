<?php

namespace App\Http\Controllers;

use App\Models\Imunisasi;
use App\Models\Jenis;
use App\Models\Balita;
use App\Models\Petugas;
use App\Models\Tempat;
use Illuminate\Http\Request;

class ImunisasiController extends Controller
{
    // TAMPILKAN SEMUA DATA
    public function tampil2(Request $request)
    {
        $tempatId = $request->filter_tempat;
        $keyword = $request->cari;

        $balita = Balita::with([
            'tempat',
            'imunisasi.jenis',
            'imunisasi.petugas' // <-- Tambahkan ini agar petugas muncul
        ])
            ->when($tempatId, fn($q) => $q->where('id_tempat', $tempatId))
            ->when($keyword, fn($q, $k) => $q->where('nama_balita', 'like', '%' . $k . '%'))
            ->paginate(10)
            ->appends($request->except('page'));

        $jenisList = Jenis::all();
        $tempatList = Tempat::all();
        $petugasList = Petugas::where('status', 'aktif')->get(); // <-- Tambahkan ini

        return view('imunisasi.tampil2', compact('balita', 'jenisList', 'tempatList', 'petugasList'));
    }


    // FORM TAMBAH
    public function tambah2()
    {
        $jenisList = Jenis::all();
        $balitaList = Balita::with('tempat')->get();
        $petugasList = Petugas::where('status', 'aktif')->get(); // Tambah ini

        return view('imunisasi.tambah2', compact('jenisList', 'balitaList', 'petugasList'));
    }

    // SIMPAN DATA
    public function submit2(Request $request)
    {
        $request->validate([
            'id_balita' => 'required|exists:balita,id',
            'id_jenis' => 'required|exists:jenis,id',
            'tanggal_imunisasi' => 'required|date',
            'id_petugas' => 'required|exists:petugas,id',
        ]);

        Imunisasi::create([
            'id_balita' => $request->id_balita,
            'id_jenis' => $request->id_jenis,
            'tanggal_imunisasi' => $request->tanggal_imunisasi,
            'id_petugas' => $request->id_petugas,
        ]);


        return redirect()->route('imunisasi.tampil2')->with('success', 'Data imunisasi berhasil ditambahkan.');
    }

    // FORM EDIT
    public function edit2($id)
    {
        $imunisasi = Imunisasi::findOrFail($id);
        $jenisList = Jenis::all();
        $balitaList = Balita::with('tempat')->get();
        $petugasList = Petugas::where('status', 'aktif')->get(); // tambahkan ini

        return view('imunisasi.edit2', compact('imunisasi', 'jenisList', 'balitaList', 'petugasList'));
    }

    // UPDATE DATA
    public function update2(Request $request, $id)
    {
        $request->validate([
            'tanggal_imunisasi' => 'required|date',
            'id_jenis' => 'required|exists:jenis,id',
            'id_petugas' => 'required|exists:petugas,id',
        ]);

        $imunisasi = Imunisasi::findOrFail($id);

        $imunisasi->update([
            'tanggal_imunisasi' => $request->tanggal_imunisasi,
            'id_jenis' => $request->id_jenis,
            'id_petugas' => $request->id_petugas,
        ]);

        return redirect()->route('imunisasi.tampil2')->with('success', 'Data imunisasi berhasil diperbarui.');
    }


    // LIHAT DETAIL
    public function lihat2($id)
    {
        $balita = Balita::with('tempat')->findOrFail($id); // Ambil data balita dan tempat

        // Ambil imunisasi dengan relasi jenis dan petugas, paginasi
        $imunisasi = Imunisasi::with('jenis', 'petugas')
            ->where('id_balita', $id)
            ->orderByDesc('tanggal_imunisasi')
            ->paginate(10);

        return view('imunisasi.lihat2', compact('balita', 'imunisasi'));
    }
}
