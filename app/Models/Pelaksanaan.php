<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaksanaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_bukti',
        'file_pdf',
        'tanggal_upload',
    ];

    // public function kategori()
    // {
    //     return $this->belongsTo(PersuratanKategori::class);
    // }

}
