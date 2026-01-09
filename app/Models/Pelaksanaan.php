<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaksanaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'rencana_id',
        'pelaksanaan_jenis_id',
        'nominal',
        'file_pdf',
        'tanggal_upload',
    ];

    public function rencana()
    {
        return $this->belongsTo(Rencana::class);
    }

    public function jenis()
    {
        return $this->belongsTo(PelaksanaanJenis::class, 'pelaksanaan_jenis_id');
    }
    public function pelaksanaanJenis()
{
    return $this->belongsTo(PelaksanaanJenis::class);
}

public function keuangans()
    {
        return $this->hasMany(Keuangan::class);
    }
}
