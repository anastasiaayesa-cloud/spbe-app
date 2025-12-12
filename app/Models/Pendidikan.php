<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pendidikan',
        
    ];
    public function kepegawaian()
    {
        return $this->belongsTo(Kepegawaian::class);
    }

}
