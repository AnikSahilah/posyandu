<?php

namespace App\Http\Controllers;

use App\Exports\BalitaTemplateExport;
use App\Imports\BalitaImport;
use App\Models\Balita;
use App\Models\Tempat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class BalitaController extends Controller
{
    function tampil4(Request $request)
    {
        $query = Balita::with('tempat');

        if ($request->has('cari') && $request->cari != '') {
            $query->where('nama_balita', 'like', '%' . $request->cari . '%');
        }

        if ($request->has('filter_tempat') && $request->filter_tempat != '') {
            $query->where('id_tempat', $request->filter_tempat);
        }

        // Paginasi 10 data per halaman
        $balita = $query->paginate(10)->appends($request->all());
        $tempat = Tempat::all();

        return view('balita.tampil4', compact('balita', 'tempat'));
    }

    public function lihat4($id)
    {
        $balita = Balita::with('tempat')->findOrFail($id);
        return view('balita.lihat4', compact('balita'));
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new BalitaImport, $request->file('file'));

        return redirect()->route('balita.tampil4')->with('success', 'Import data balita berhasil!');
    }


    function tambah4()
    {
        $tempat = Tempat::all();
        return view('balita.tambah4', compact('tempat'));
    }

    function submit4(Request $request)
    {
        $request->validate([
            'nik_balita' => 'required|unique:balita,nik_balita',
            'nama_balita' => 'required',
            'balita_ke' => 'required|integer',
            'tanggal_lahir' => 'required|date',
            'berat_badan_lahir' => 'required|numeric',
            'tinggi_lahir' => 'required|numeric',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_orang_tua' => 'required',
            'nik_orang_tua' => 'required',
            'no_hp' => 'required',
            'id_tempat' => 'required|exists:tempat,id',
            'rt' => 'required',
            'rw' => 'required',
            'buku_kia' => 'required',
            'inisiasi_menyusui_dini' => 'nullable',
        ]);

        $balita = Balita::create([
            'nik_balita' => $request->nik_balita,
            'nama_balita' => $request->nama_balita,
            'balita_ke' => $request->balita_ke,
            'tanggal_lahir' => $request->tanggal_lahir,
            'berat_badan_lahir' => $request->berat_badan_lahir,
            'tinggi_lahir' => $request->tinggi_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_orang_tua' => $request->nama_orang_tua,
            'nik_orang_tua' => $request->nik_orang_tua,
            'no_hp' => $request->no_hp,
            'id_tempat' => $request->id_tempat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'buku_kia' => $request->buku_kia,
            'inisiasi_menyusui_dini' => $request->inisiasi_menyusui_dini,
        ]);

        // Cek apakah user dengan email = nik_orang_tua sudah ada
        $existingUser = User::where('email', $request->nik_orang_tua)->first();

        if (!$existingUser) {
            User::create([
                'name' => $request->nama_orang_tua,
                'email' => $request->nik_orang_tua,
                'password' => Hash::make($request->nik_orang_tua),
                'tipeuser' => 'user',
            ]);
        }

        return redirect()->route('balita.tampil4')->with('success', 'Data balita & akun user berhasil ditambahkan!');
    }

    function edit4($id)
    {
        $balita = Balita::findOrFail($id);
        $tempat = Tempat::all();
        return view('balita.edit4', compact('balita', 'tempat'));
    }

    function update4(Request $request, $id)
    {
        $balita = Balita::findOrFail($id);

        $request->validate([
            'nik_balita' => 'required|unique:balita,nik_balita,' . $id, // abaikan data saat ini
            'nama_balita' => 'required',
            'balita_ke' => 'required|integer',
            'tanggal_lahir' => 'required|date',
            'berat_badan_lahir' => 'required|numeric',
            'tinggi_lahir' => 'required|numeric',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_orang_tua' => 'required',
            'nik_orang_tua' => 'required',
            'no_hp' => 'required',
            'id_tempat' => 'required|exists:tempat,id',
            'rt' => 'required',
            'rw' => 'required',
            'buku_kia' => 'required',
            'inisiasi_menyusui_dini' => 'nullable',
        ]);

        $balita->update([
            'nik_balita' => $request->nik_balita,
            'nama_balita' => $request->nama_balita,
            'balita_ke' => $request->balita_ke,
            'tanggal_lahir' => $request->tanggal_lahir,
            'berat_badan_lahir' => $request->berat_badan_lahir,
            'tinggi_lahir' => $request->tinggi_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_orang_tua' => $request->nama_orang_tua,
            'nik_orang_tua' => $request->nik_orang_tua,
            'no_hp' => $request->no_hp,
            'id_tempat' => $request->id_tempat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'buku_kia' => $request->buku_kia,
            'inisiasi_menyusui_dini' => $request->inisiasi_menyusui_dini,
        ]);

        return redirect()->route('balita.tampil4')->with('success', 'Data balita berhasil diperbarui!');
    }

    function delete4($id)
    {
        $balita = Balita::findOrFail($id);
        $balita->delete();

        return redirect()->route('balita.tampil4')->with('success', 'Data balita berhasil dihapus!');
    }
}
