<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perencanaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokumen_perencanaan_id',
        'kode',
        'nama',
        'volume',
        'jumlah_biaya',
    ];

    // public function status()
    // {
    //     return $this->belongsTo(Status::class);
    // }

    public function dokumen_perencanaan()
    {
        return $this->belongsTo(DokumenPerencanaan::class);
    }

    public function details()
    {
        return $this->hasMany(PerencanaanDetail::class);
    }

    public function rencanas()
    {
        return $this->belongsToMany(
            Rencana::class,
            'perencanaan_rencana'
        );
    }



//     public function perencanaanNama()
// {
//     return $this->belongsTo(PerencanaanNama::class);
// }

}
