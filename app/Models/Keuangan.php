<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelaksanaan_id',
        'status',
        'total_nominal',
        'lunas_at', // ⬅️ wajib
    ];

    protected $casts = [
        'lunas_at' => 'datetime',
    ];

    public function pelaksanaan()
    {
        return $this->belongsTo(Pelaksanaan::class);
    }

    public function detailKeuangans()
    {
        return $this->hasMany(DetailKeuangan::class, 'keuangan_id');
    }
}
