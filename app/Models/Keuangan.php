<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailKeuangan;


class Keuangan extends Model
{
    use HasFactory;

    protected $fillable = [
    'kepegawaian_id',
    'pelaksanaan_id',
    'status',
    'total_nominal'
    ];

    public function rencana()
{
    return $this->belongsTo(Rencana::class);
}

public function pelaksanaan()
{
    return $this->belongsTo(Pelaksanaan::class);
}

public function detailKeuangans()
    {
        return $this->hasMany(
            DetailKeuangan::class,
            'keuangan_id' // FK di tabel detail_keuangans
        );
    }

    public function kepegawaians()
    {
        return $this->belongsToMany(
            Kepegawaian::class,
            'pivot_pegawai', // ganti sesuai tabel pivot
            'rencana_id',
            'kepegawaian_id'
        );
    }

   public function getTotalNominalAttribute()
{
    return $this->pelaksanaan
        ->rencana
        ->pelaksanaans
        ->sum('nominal');
}
    
}
