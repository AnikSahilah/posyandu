<?php

namespace App\Models;

use App\Models\Pemeriksaan_Balita;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    use HasFactory;
    protected $table = 'balita';
    protected $primaryKey = 'id'; // Sesuaikan dengan nama tabel    

    protected $fillable = [
        'nik_balita',
        'nama_balita',
        'balita_ke',
        'tanggal_lahir',
        'berat_badan_lahir',
        'tinggi_lahir',
        'jenis_kelamin',
        'nama_orang_tua',
        'nik_orang_tua',
        'no_hp',
        'id_tempat',
        'rt',
        'rw',
        'buku_kia',
        'inisiasi_menyusui_dini'
    ];

    public function pemeriksaan_balita()
    {
        return $this->hasMany(PemeriksaanBalita::class, 'id_balita', 'id');
    }

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'id_tempat', 'id');
    }

    public function imunisasi()
    {
        return $this->hasMany(Imunisasi::class, 'id_balita', 'id');
    }
}
