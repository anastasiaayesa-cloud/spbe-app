<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persuratan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_surat',
        'penerima_surat',
        'persuratan_kategori_id',
        'perihal',
        'file_pdf',
        'jenis_anggaran',
    ];

    public function kategori()
    {
        return $this->belongsTo(PersuratanKategori::class);
    }
    public function rencana()
    {
        return $this->belongsTo(Rencana::class);
    }

    public function kepegawaians()
    {
        return $this->belongsToMany(Kepegawaian::class, 'kepegawaian_persuratan');
    }

    public function rencanas()
    {
        return $this->belongsToMany(
            Rencana::class, 
            'pivot_persuratans_rencanas', // Nama tabel pivot di database kamu
            'persuratan_id', 
            'rencana_id'
        );
    }

}
