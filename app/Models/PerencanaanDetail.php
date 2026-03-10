<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerencanaanDetail extends Model
{
    // Pastikan fillable lengkap agar bisa disimpan/dibaca
    protected $fillable = [
        'perencanaan_id',
        'uraian_rincian',
        'volume',
        'volume_satuan',
        'harga_satuan',
        'subtotal_biaya'
    ];

    public function perencanaan()
    {
        return $this->belongsTo(Perencanaan::class);
    }
}
