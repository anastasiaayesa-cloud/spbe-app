<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persuratan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_surat',
        'file_pdf',
        'tanggal_upload',
        'persuratan_kategori_id',
        'kepada',
        'perihal',
        'jenis_anggaran'
    ];

    public function kategori()
    {
        return $this->belongsTo(PersuratanKategori::class);
    }

}
