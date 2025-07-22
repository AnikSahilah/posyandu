<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Edukasi;
use App\Models\Imunisasi;
use App\Models\Jadwal;
use App\Models\Jenis;
use App\Models\PemeriksaanBalita;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $now = Carbon::now();

        // Hitung balita bulan ini dan bulan lalu
        $startOfThisMonth = $now->copy()->startOfMonth();
        $endOfThisMonth = $now->copy()->endOfMonth();

        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $thisMonthCount = Balita::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();
        $lastMonthCount = Balita::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $totalBalita = Balita::count();

        // Hitung pertumbuhan data balita
        $growth = 0;
        if ($lastMonthCount > 0) {
            $growth = (($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100;
        } elseif ($thisMonthCount > 0) {
            $growth = 100;
        }

        // Jumlah total jenis imunisasi
        $totalJenis = Jenis::count();

        // Jumlah edukasi yang diterbitkan
        $totalEdukasi = Edukasi::count();

        // Jumlah imunisasi dalam 30 hari terakhir
        $thirtyDaysAgo = $now->copy()->subDays(30);
        $imunisasiTerbaruCount = Imunisasi::where('created_at', '>=', $thirtyDaysAgo)->count();

        // Aktivitas terkini
        $activities = collect();

        // 1. Balita baru
        $activities = $activities->merge(
            Balita::latest()->take(3)->get()->map(function ($balita) {
                return [
                    'icon' => 'baby',
                    'color' => 'bg-blue-100 text-blue-600',
                    'title' => 'Balita Baru',
                    'desc' => "{$balita->nama_balita} (Ke-{$balita->balita_ke})",
                    'time' => $balita->created_at,
                ];
            })
        );

        // 2. Imunisasi baru
        $activities = $activities->merge(
            Imunisasi::with('jenis')->latest()->take(3)->get()->map(function ($imunisasi) {
                $jumlah = $imunisasi->jumlah ?? 1;
                return [
                    'icon' => 'syringe',
                    'color' => 'bg-purple-100 text-purple-600',
                    'title' => 'Imunisasi Baru',
                    'desc' => "{$imunisasi->jenis->nama} untuk {$jumlah} balita",
                    'time' => $imunisasi->created_at,
                ];
            })
        );

        // 3. Jadwal posyandu baru
        $activities = $activities->merge(
            Jadwal::with('tempat')->latest()->take(3)->get()->map(function ($jadwal) {
                return [
                    'icon' => 'calendar-check',
                    'color' => 'bg-green-100 text-green-600',
                    'title' => 'Jadwal Baru',
                    'desc' => "{$jadwal->tempat->nama} - " . Carbon::parse($jadwal->tanggal_posyandu)->translatedFormat('d F Y'),
                    'time' => $jadwal->created_at,
                ];
            })
        );

        // 4. Edukasi baru
        $activities = $activities->merge(
            Edukasi::latest()->take(3)->get()->map(function ($edukasi) {
                return [
                    'icon' => 'book-reader',
                    'color' => 'bg-yellow-100 text-yellow-600',
                    'title' => 'Edukasi Baru',
                    'desc' => $edukasi->judul,
                    'time' => $edukasi->created_at,
                ];
            })
        );

        // 5. Pemeriksaan balita
        $activities = $activities->merge(
            PemeriksaanBalita::with('balita')->latest()->take(3)->get()->map(function ($periksa) {
                return [
                    'icon' => 'notes-medical',
                    'color' => 'bg-red-100 text-red-600',
                    'title' => 'Pemeriksaan Balita',
                    'desc' => $periksa->balita->nama_balita . " (Umur {$periksa->umur} bln)",
                    'time' => $periksa->created_at,
                ];
            })
        );

        // Urutkan berdasarkan waktu terbaru
        $activities = $activities->sortByDesc('time')->take(5);

        return view('admin.dashboard', compact(
            'totalBalita',
            'growth',
            'totalJenis',
            'totalEdukasi',
            'imunisasiTerbaruCount',
            'activities'
        ));
    }
}
