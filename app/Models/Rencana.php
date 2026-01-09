<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rencana extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'tanggal_kegiatan',
        'lokasi_kegiatan',
    ];

    /**
     * Pegawai yang terlibat dalam rencana
     */
    public function kepegawaians()
    {
        return $this->belongsToMany(
            Kepegawaian::class,
            'kepegawaian_rencana_pivot'
        );
    }

    /**
     * Persuratan berdasarkan rencana
     */
    public function persuratans()
    {
        return $this->hasMany(Persuratan::class);
    }

    /**
     * Pelaksanaan berdasarkan rencana
     */
    public function pelaksanaans()
    {
        return $this->hasMany(Pelaksanaan::class);
    }

    /**
     * (Opsional) relasi perencanaan
     */
    public function perencanaans()
    {
        return $this->belongsToMany(
            Perencanaan::class,
            'perencanaan_rencana'
        );
    }
}
