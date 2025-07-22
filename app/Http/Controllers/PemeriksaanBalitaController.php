<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Tempat;
use App\Models\PemeriksaanBalita;
use App\Models\Petugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PemeriksaanBalitaController extends Controller
{
    // Tampilkan semua balita dan pemeriksaan terakhir
    public function tampil5(Request $request)
    {
        $filterTempat = $request->filter_tempat;
        $keyword = $request->cari;

        $query = Balita::with([
            'pemeriksaan_balita' => function ($q) {
                $q->latest('tanggal_pemeriksaan')->with('petugas'); // ⬅ tambahkan relasi petugas
            },
            'tempat'
        ]);

        if (!empty($filterTempat)) {
            $query->where('id_tempat', $filterTempat);
        }

        if (!empty($keyword)) {
            $query->where('nama_balita', 'like', '%' . $keyword . '%');
        }

        $balita = $query->paginate(10)->appends($request->all());
        $tempat = Tempat::all();

        return view('pemeriksaan.tampil5', compact('balita', 'tempat',));
    }

    // Form tambah pemeriksaan
    public function tambah5($id_balita)
    {
        $balita = Balita::with('tempat')->findOrFail($id_balita);
        $petugas = Petugas::where('status', 'aktif')->get(); // Ambil hanya petugas aktif

        return view('pemeriksaan.tambah5', compact('balita', 'petugas'));
    }

    // Simpan pemeriksaan baru
    public function simpan5(Request $request)
    {
        $request->validate([
            'id_balita' => 'required|exists:balita,id',
            'id_petugas' => 'required|exists:petugas,id', // ⬅ tambah ini
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);


        $balita = Balita::findOrFail($request->id_balita);

        $tanggalLahir = new \DateTime($balita->tanggal_lahir);
        $tanggalPemeriksaan = new \DateTime($request->tanggal_pemeriksaan);
        $selisih = $tanggalLahir->diff($tanggalPemeriksaan);
        $umurBulan = ($selisih->y * 12) + $selisih->m;

        // Cek apakah tanggal_pemeriksaan masih sebelum tanggal lahir di bulan itu
        if ($tanggalPemeriksaan->format('d') < $tanggalLahir->format('d')) {
            $umurBulan -= 1;
        }

        // Minimal umur adalah 0
        $umurBulan = max(0, $umurBulan);


        $status = $this->hitungStatusGizi($umurBulan, $request->berat_badan, $request->tinggi_badan, $balita->jenis_kelamin);

        PemeriksaanBalita::create([
            'id_balita' => $request->id_balita,
            'id_petugas' => $request->id_petugas, // ⬅ simpan petugas
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'umur' => $umurBulan,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'status' => $status,
        ]);


        return redirect()->route('pemeriksaan.tampil5', ['page' => $request->page])
            ->with('success', 'Pemeriksaan berhasil ditambahkan.');
    }


    // Detail riwayat pemeriksaan satu balita
    public function lihat5($id)
    {
        $balita = Balita::with('tempat', 'pemeriksaan_balita')->findOrFail($id);
        $tahunTerpilih = request('tahun') ?? now()->year;

        $pemeriksaan = PemeriksaanBalita::with('petugas') // ⬅ tambahkan relasi ini
            ->where('id_balita', $id)
            ->whereYear('tanggal_pemeriksaan', $tahunTerpilih)
            ->orderBy('tanggal_pemeriksaan', 'asc')
            ->paginate(12);


        $tahunTersedia = PemeriksaanBalita::where('id_balita', $id)
            ->selectRaw('YEAR(tanggal_pemeriksaan) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('pemeriksaan.lihat5', [
            'balita' => $balita,
            'pemeriksaan' => $pemeriksaan,
            'tahunTerpilih' => $tahunTerpilih,
            'tahunTersedia' => $tahunTersedia,
        ]);
    }

    // Form edit pemeriksaan
    public function edit5($id)
    {
        $pemeriksaan_balita = PemeriksaanBalita::with('balita')->findOrFail($id);
        $petugas = Petugas::where('status', 'aktif')->get(); // Ambil hanya petugas aktif

        return view('pemeriksaan.edit5', compact('pemeriksaan_balita', 'petugas'));
    }

    // Update data pemeriksaan
    public function update5(Request $request, $id)
    {
        $request->validate([
            'id_balita' => 'required|exists:balita,id',
            'id_petugas' => 'required|exists:petugas,id', // ⬅ Tambahkan ini
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);


        $pemeriksaan = PemeriksaanBalita::findOrFail($id);
        $balita = Balita::findOrFail($request->id_balita);

        $tanggalLahir = new \DateTime($balita->tanggal_lahir);
        $tanggalPemeriksaan = new \DateTime($request->tanggal_pemeriksaan);
        $selisih = $tanggalLahir->diff($tanggalPemeriksaan);
        $umurBulan = ($selisih->y * 12) + $selisih->m;

        $status = $this->hitungStatusGizi($umurBulan, $request->berat_badan, $request->tinggi_badan, $balita->jenis_kelamin);

        $pemeriksaan->update([
            'id_balita' => $request->id_balita,
            'id_petugas' => $request->id_petugas, // ⬅ Simpan petugas pemeriksa
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'umur' => $umurBulan,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'status' => $status,
        ]);


        return redirect()->route('pemeriksaan.tampil5')->with('success', 'Pemeriksaan berhasil diperbarui.');
    }

    // 🔍 Fungsi utama status gizi akhir
    private function hitungStatusGizi($umur, $bb, $tb, $jk)
    {
        $z_score = $this->hitungZScoreWHO($bb, $umur, $jk);

        if ($z_score < -3) {
            return 'Gizi Buruk';
        } elseif ($z_score >= -3 && $z_score < -2) {
            return 'Gizi Kurang';
        } else {
            return $this->cekStunting($tb, $umur, $jk) ? 'Stunting' : 'Gizi Normal';
        }
    }

    // Hitung Z-Score dari berat badan
    private function hitungZScoreWHO($berat_badan, $umur_bulan, $jenis_kelamin)
    {
        $jenis_kelamin = strtolower($jenis_kelamin) === 'l' ? 'Laki-laki' : 'Perempuan';

        $data = [
            'Laki-laki' => [
                12 => ['median' => 9.6, 'sd' => 1.1],
                24 => ['median' => 12.2, 'sd' => 1.2],
                36 => ['median' => 14.3, 'sd' => 1.4],
                48 => ['median' => 16.3, 'sd' => 1.5],
            ],
            'Perempuan' => [
                12 => ['median' => 8.9, 'sd' => 1.0],
                24 => ['median' => 11.5, 'sd' => 1.1],
                36 => ['median' => 13.9, 'sd' => 1.3],
                48 => ['median' => 15.8, 'sd' => 1.4],
            ]
        ];

        $umurTerdekat = null;
        foreach ($data[$jenis_kelamin] as $umur => $value) {
            if ($umur_bulan <= $umur) {
                $umurTerdekat = $umur;
                break;
            }
        }

        if (!$umurTerdekat) {
            $umurTerdekat = 48;
        }

        $median = $data[$jenis_kelamin][$umurTerdekat]['median'];
        $sd = $data[$jenis_kelamin][$umurTerdekat]['sd'];

        return round(($berat_badan - $median) / $sd, 2);
    }

    // Cek apakah tinggi badan menunjukkan stunting
    private function cekStunting($tinggi_badan, $umur_bulan, $jenis_kelamin)
    {
        $tinggi_ideal = 45 + ($umur_bulan * 0.5);
        if (strtolower($jenis_kelamin) === 'l' || strtolower($jenis_kelamin) === 'laki-laki') {
            $tinggi_ideal += 1;
        }

        $selisih = $tinggi_badan - $tinggi_ideal;

        return $selisih < -2;
    }
}
