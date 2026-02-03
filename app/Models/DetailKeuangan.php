<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKeuangan extends Model
{
    protected $fillable = [
        'keuangan_id',
        'kepegawaian_id',
        'uraian',
        'nominal',
    ];

    public function keuangan()
    {
        return $this->belongsTo(Keuangan::class);
    }

    public function kepegawaian()
    {
        return $this->belongsTo(Kepegawaian::class, 'kepegawaian_id');
    }
}
