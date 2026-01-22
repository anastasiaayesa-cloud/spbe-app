<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKeuangan extends Model
{
    protected $fillable = [
        'keuangan_id',
        'uraian',
        'nominal',
    ];

    public function keuangan()
    {
        return $this->belongsTo(Keuangan::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Kepegawaian::class, 'pegawai_id');
    }
}
