<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Tempat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // Tampil semua jadwal
    public function tampil(Request $request)
    {
        $tahunDipilih = $request->get('tahun', Carbon::now()->year); // Default tahun sekarang

        // Ambil semua tahun unik yang tersedia di tabel jadwal
        $listTahun = Jadwal::selectRaw('YEAR(tanggal_posyandu) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Ambil data jadwal berdasarkan tahun dipilih
        $jadwal = Jadwal::with('tempat')
            ->whereYear('tanggal_posyandu', $tahunDipilih)
            ->orderBy('tanggal_posyandu', 'desc')
            ->paginate(10);

        $tempat = Tempat::all();

        return view('jadwal.tampil', compact('jadwal', 'tempat', 'listTahun', 'tahunDipilih'));
    }



    // Simpan jadwal baru
    public function submit(Request $request)
    {
        $request->validate([
            'id_tempat' => 'required|exists:tempat,id',
            'tanggal_posyandu' => 'required|date',
        ]);

        Jadwal::create([
            'id_tempat' => $request->id_tempat,
            'tanggal_posyandu' => $request->tanggal_posyandu,
        ]);

        return redirect()->route('jadwal.tampil')->with('success', 'Jadwal berhasil ditambahkan');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $tempat = Tempat::all();
        return view('jadwal.edit', compact('jadwal', 'tempat'));
    }

    // Proses update
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_tempat' => 'required|exists:tempat,id',
            'tanggal_posyandu' => 'required|date',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update([
            'id_tempat' => $request->id_tempat,
            'tanggal_posyandu' => $request->tanggal_posyandu,
        ]);

        return redirect()->route('jadwal.tampil')->with('success', 'Jadwal berhasil diperbarui');
    }

    // Hapus jadwal
    public function delete($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.tampil')->with('success', 'Jadwal berhasil dihapus');
    }
}
