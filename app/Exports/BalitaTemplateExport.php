<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BalitaTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return []; // Kosong, hanya template
    }

    public function headings(): array
    {
        return [
            'nik_balita',
            'nama_balita',
            'balita_ke',
            'tanggal_lahir',
            'berat_badan_lahir',
            'tinggi_lahir',
            'jenis_kelamin',
            'nama_orang_tua',
            'id_tempat',
            'rt',
            'rw',
            'buku_kia',
            'inisiasi_menyusui_dini',
        ];
    }
}
