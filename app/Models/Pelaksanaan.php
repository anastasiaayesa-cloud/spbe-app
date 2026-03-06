<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaksanaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'rencana_id',
        'kepegawaian_id',
        'pelaksanaan_jenis_id',
        'nominal',
        'file_pdf',
        'file_type',      // 👈 TAMBAH
        'tanggal_upload',
        // 'keterangan',

    ];

    public function rencana()
    {
        return $this->belongsTo(Rencana::class);
    }


    public function pelaksanaanJenis()
{
    return $this->belongsTo(PelaksanaanJenis::class);
}

public function keuangans()
    {
        return $this->hasMany(Keuangan::class);
    }

    public function kepegawaian()
{
    return $this->belongsTo(Kepegawaian::class);
}
}
