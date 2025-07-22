<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use App\Models\Jadwal;
use App\Models\Jenis;
use App\Models\Kegiatan;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $kegiatan = Kegiatan::all();
        $petugas = Petugas::all();
        $edukasi = Edukasi::latest()->take(3)->get();

        $jadwalBulanIni = Jadwal::whereMonth('tanggal_posyandu', Carbon::now()->month)
            ->whereYear('tanggal_posyandu', Carbon::now()->year)
            ->orderBy('tanggal_posyandu', 'asc')
            ->get();

        $jenis = Jenis::latest()->take(3)->get(); // ✅ hanya ambil 3 data terbaru

        return view('welcome', compact('kegiatan', 'petugas', 'jadwalBulanIni', 'edukasi', 'jenis'));
    }



    public function jadwal(Request $request)
    {
        // Ambil parameter tahun dari request, default tahun saat ini
        $selectedYear = $request->input('tahun', date('Y'));

        // Validasi input tahun
        if (!is_numeric($selectedYear)) {
            $selectedYear = date('Y');
        }

        // Ambil daftar tahun yang tersedia dari database
        $availableYears = Jadwal::selectRaw('YEAR(tanggal_posyandu) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Jika tahun yang dipilih tidak tersedia, gunakan tahun terbaru
        if (!$availableYears->contains($selectedYear)) {
            $selectedYear = $availableYears->first() ?? date('Y');
        }

        // Query data jadwal untuk tahun yang dipilih
        $jadwal = Jadwal::with('tempat')
            ->whereYear('tanggal_posyandu', $selectedYear)
            ->orderBy('tanggal_posyandu', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal_posyandu)->translatedFormat('F');
            });

        // Pastikan semua bulan ada dalam hasil (meski kosong)
        $allMonths = collect();
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->translatedFormat('F');
            $allMonths[$monthName] = $jadwal[$monthName] ?? collect();
        }

        return view('home.jadwal', [
            'jadwal' => $allMonths,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears,
            'currentYear' => date('Y')
        ]);
    }

    public function edukasi()
    {
        $edukasi = Edukasi::latest()->get(); // Ambil data edukasi terbaru
        return view('home.edukasi', compact('edukasi'));
    }

    public function jenis()
    {
        $jenis = Jenis::all(); // ambil semua data jenis imunisasi
        return view('home.jenis', compact('jenis'));
    }
}
