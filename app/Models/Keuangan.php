<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_sppd',
        'pelaksanaan_id',
        'tanggal_sppd',
    ];

    public function rencana()
{
    return $this->belongsTo(Rencana::class);
}

public function pelaksanaan()
{
    return $this->belongsTo(Pelaksanaan::class);
}

}
