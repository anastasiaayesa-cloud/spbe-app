<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerencanaanNama extends Model
{
    use HasFactory;
     protected $fillable = [
        'nama',
        
    ];

  public function dokumenPerencanaans()
{
    return $this->hasMany(DokumenPerencanaan::class);
}


}
