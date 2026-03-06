<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaksanaanJenis extends Model
{
    use HasFactory;

    protected $table = 'pelaksanaan_jenis';

    protected $fillable = [
        'nama',
    ];

    public function pelaksanaans()
    {
        return $this->hasMany(Pelaksanaan::class, 'pelaksanaan_jenis_id');
    }
}
