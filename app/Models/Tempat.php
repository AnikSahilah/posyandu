<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempat extends Model
{
    use HasFactory;
    protected $table = 'tempat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tempat_posyandu',
    ];

    public function balita()
    {
        return $this->hasMany(Balita::class, 'id_tempat', 'id');
    }

    public function tempat()
    {
        return $this->hasMany(Jadwal::class, 'id_tempat', 'id');
    }

    public function pemeriksaan_balita()
    {
        return $this->hasManyThrough(
            \App\Models\PemeriksaanBalita::class,
            \App\Models\Balita::class,
            'id_tempat', // foreign key di Balita
            'id_balita', // foreign key di PemeriksaanBalita
            'id',        // local key di Tempat
            'id'         // local key di Balita
        );
    }
}
