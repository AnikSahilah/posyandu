<?php

namespace App\Imports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Balita;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BalitaImport implements ToModel
{
    public function model(array $row)
    {
        // Lewati baris header
        if ($row[0] === 'nik_balita') {
            return null;
        }

        return new Balita([
            'nik_balita' => $row[0],
            'nama_balita' => $row[1],
            'balita_ke' => $row[2],
            'tanggal_lahir' => Date::excelToDateTimeObject($row[3])->format('Y-m-d'),
            'berat_badan_lahir' => $row[4],
            'tinggi_lahir' => $row[5],
            'jenis_kelamin' => $row[6],
            'nama_orang_tua' => $row[7],
            'id_tempat' => $row[8],
            'rt' => $row[9],
            'rw' => $row[10],
            'buku_kia' => $row[11],
            'inisiasi_menyusui_dini' => $row[12],
        ]);
    }
}
