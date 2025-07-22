<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;
    protected $table = 'petugas';
    protected $primaryKey = 'id'; // Sesuaikan dengan nama tabel    

    protected $fillable = [
        'nama_petugas',
        'jabatan_petugas',
        'jenis_kelamin',
        'status',
        'nomer_hp'
    ];

    public function pemeriksaan_balita()
    {
        return $this->hasMany(PemeriksaanBalita::class, 'id_petugas', 'id');
    }
    public function imunisasi()
    {
        return $this->hasMany(Imunisasi::class, 'id_petugas', 'id');
    }
}
