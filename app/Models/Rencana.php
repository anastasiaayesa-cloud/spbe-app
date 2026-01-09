<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rencana extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'tanggal_kegiatan',
        'lokasi_kegiatan',
    ];

    public function kepegawaians()
    {
        return $this->belongsToMany(
            Kepegawaian::class,
            'kepegawaian_rencana_pivot'
        );
    }

    public function perencanaans()
    {
        return $this->belongsToMany(
            Perencanaan::class,
            'perencanaan_rencana'
        );
    }

    public function persuratans()
    {
        return $this->belongsToMany(Persuratan::class, 'pivot_persuratans_rencanas');
    }

}


