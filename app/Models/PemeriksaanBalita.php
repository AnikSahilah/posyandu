<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanBalita extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_balita';
    protected $primaryKey = 'id';

    // Kolom yang boleh diisi melalui mass assignment
    protected $fillable = [
        'id_balita',
        'id_petugas',
        'tanggal_pemeriksaan',
        'umur',
        'berat_badan',
        'tinggi_badan',
        'status',
    ];

    // Relasi: Perkembangan dimiliki oleh satu Anak
    public function balita()
    {
        return $this->belongsTo(Balita::class, 'id_balita', 'id');
    }
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id');
    }
}
