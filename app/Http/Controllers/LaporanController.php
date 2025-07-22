<?php

namespace App\Http\Controllers;

use App\Models\Imunisasi;
use App\Models\PemeriksaanBalita;
use App\Models\Tempat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->jenis ?? 'pemeriksaan';
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $tahunList = range(now()->year, now()->year - 5);
        $data = [];

        if ($jenis === 'pemeriksaan') {
            $data = PemeriksaanBalita::with('balita.tempat', 'petugas')
                ->whereMonth('tanggal_pemeriksaan', $bulan)
                ->whereYear('tanggal_pemeriksaan', $tahun)
                ->paginate(10)
                ->appends($request->all());
        } elseif ($jenis === 'imunisasi') {
            $data = Imunisasi::with('balita.tempat', 'jenis', 'petugas')
                ->whereMonth('tanggal_imunisasi', $bulan)
                ->whereYear('tanggal_imunisasi', $tahun)
                ->paginate(10)
                ->appends($request->all());
        } elseif ($jenis === 'clustering') {
            $data = \App\Models\Tempat::paginate(10)->appends($request->all());
        }

        return view('laporan.index', compact('jenis', 'bulan', 'tahun', 'tahunList', 'data'));
    }


    public function exportPDF(Request $request)
    {
        $jenis = $request->jenis;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if ($jenis === 'pemeriksaan') {
            $data = PemeriksaanBalita::with('balita.tempat', 'petugas')
                ->whereMonth('tanggal_pemeriksaan', $bulan)
                ->whereYear('tanggal_pemeriksaan', $tahun)
                ->get();
            $pdf = PDF::loadView('laporan.pdf_pemeriksaan', compact('data', 'bulan', 'tahun'));
        } elseif ($jenis === 'imunisasi') {
            $data = Imunisasi::with('balita.tempat', 'jenis', 'petugas')
                ->whereMonth('tanggal_imunisasi', $bulan)
                ->whereYear('tanggal_imunisasi', $tahun)
                ->get();
            $pdf = PDF::loadView('laporan.pdf_imunisasi', compact('data', 'bulan', 'tahun'));
        } elseif ($jenis === 'clustering') {
            $data = Tempat::all();
            $pdf = PDF::loadView('laporan.pdf_clustering', compact('data'));
        }

        return $pdf->stream('laporan-' . $jenis . '-' . $bulan . '-' . $tahun . '.pdf');
    }
}
