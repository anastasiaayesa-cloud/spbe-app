<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rencana extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'tanggal_kegiatan',
    ];

    public function kepegawaians()
    {
        return $this->belongsToMany(Kepegawaian::class, 'kepegawaian_rencana_pivot');
    }
}
