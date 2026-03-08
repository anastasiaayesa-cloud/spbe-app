<?php

namespace App\Imports;

use App\Models\Perencanaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // skip baris pertama (nama kolom)

class PerencanaanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Menggunakan trim untuk membersihkan spasi yang tidak sengaja terketik di Excel
        return new Perencanaan([
            'dokumen_perencanaan_id' => $row['dokumen_perencanaan_id'] ?? null,
            'kode'                   => isset($row['kode']) ? trim($row['kode']) : null,
            'nama'                   => isset($row['nama']) ? trim($row['nama']) : null,
            'volume'                 => isset($row['volume']) ? trim($row['volume']) : null,
            'jumlah_biaya'           => $row['jumlah_biaya'] ?? 0,
        ]);
    }
}
