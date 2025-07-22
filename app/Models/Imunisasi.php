<?php

namespace App\Models;

use App\Http\Controllers\JenisController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imunisasi extends Model
{
    use HasFactory;

    protected $table = 'imunisasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_balita',
        'id_petugas',
        'tanggal_imunisasi',
        'id_jenis',
    ];

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'id_jenis', 'id');
    }

    public function balita()
    {
        return $this->belongsTo(Balita::class, 'id_balita', 'id');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id');
    }
}
