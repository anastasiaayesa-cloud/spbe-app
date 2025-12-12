<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;
        protected $fillable = [
        'nama_instansi',
        'alamat_instansi',
        'telp_instansi',
        'kabupaten_id',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function kepegawaians()
{
    return $this->hasMany(Kepegawaian::class, 'instansi_id');
}



}
