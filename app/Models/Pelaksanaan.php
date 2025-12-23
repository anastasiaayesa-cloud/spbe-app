<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaksanaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'pelaksanaan_jenis_id',
        'file_pdf',
        'tanggal_upload',
    ];

    public function jenis()
    {
        return $this->belongsTo(PelaksanaanJenis::class, 'pelaksanaan_jenis_id');
    }
    

}
