<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function tampil14()
    {
        $user = Auth::user(); // Ambil data user login
        $nik = $user->email;

        $balita = Balita::where('nik_orang_tua', $nik)
            ->with([
                'pemeriksaan_balita',
                'imunisasi.jenis',
                'tempat'
            ])
            ->first();

        $riwayat = collect();

        if ($balita) {
            foreach ($balita->pemeriksaan_balita as $p) {
                $imunisasi = $balita->imunisasi
                    ->where('tanggal_imunisasi', '<=', $p->tanggal_pemeriksaan)
                    ->sortByDesc('tanggal_imunisasi')
                    ->first();

                $riwayat->push([
                    'tanggal' => $p->tanggal_pemeriksaan,
                    'umur' => $p->umur,
                    'berat_badan' => $p->berat_badan,
                    'tinggi_badan' => $p->tinggi_badan,
                    'status' => $p->status,
                    'jenis_imunisasi' => $imunisasi->jenis->jenis_imunisasi ?? '-',
                    'keterangan_imunisasi' => $imunisasi->jenis->keterangan ?? '-',
                ]);
            }

            // Urutkan agar data terbaru di atas
            $riwayat = $riwayat->sortByDesc('tanggal')->values();
        }

        return view('user.tampil14', compact('balita', 'riwayat', 'user'));
    }
}
