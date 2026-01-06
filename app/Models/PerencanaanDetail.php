<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerencanaanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'perencanaan_id',
        'uraian_rincian',
        'volume',
        'volume_satuan',
        'harga_satuan',
        'subtotal_biaya',
    ];

    public function perencanaan()
    {
        return $this->belongsTo(Perencanaan::class);
    }
}
