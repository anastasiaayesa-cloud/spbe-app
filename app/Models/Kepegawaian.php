<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepegawaian extends Model
{

    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'pangkat_id',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'agama',
        // 'nama_instansi',
        // 'alamat_instansi',
        // 'telp_instansi',
        // 'kode_kabupaten',
        'instansi_id',
        'hp',
        'email',
        'npwp',
        'bank_id',
        'no_rek',
        'pendidikan_terakhir_id',
        'is_bpmp'
    ];

    public function pangkats()
    {
        return $this->belongsTo(Pangkat::class);
    }
}
