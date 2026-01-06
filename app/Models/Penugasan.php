<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai',
        'nama_tugas',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
}
