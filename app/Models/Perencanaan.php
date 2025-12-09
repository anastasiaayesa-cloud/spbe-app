<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perencanaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'komponen',
        'uraian_komponen',
        'sub_komponen',
        'uraian_sub_komponen',
        'nama_aktivitas',
        'rencana_mulai',
        'rencana_selesai',
        'realisasi_mulai',
        'realisasi_selesai',
        'keterangan',
        'terlaksana_id',
        'status_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
