<?php

namespace App\Services\Pelaksanaan;

use App\Models\Pelaksanaan;
use App\Models\PelaksanaanJenis;
use App\Models\Rencana;

class PelaksanaanService
{
    public function getPelaksanaanJenis()
    {
        return PelaksanaanJenis::orderBy('nama')->get();
    }

    public function getLaporanJenisId()
    {
        return PelaksanaanJenis::where('nama', 'Laporan Kegiatan')->value('id');
    }

    public function getRencana($id)
    {
        return Rencana::findOrFail($id);
    }

    public function defaultLampiran()
    {
        return [[
            'file' => null,
            'pelaksanaan_jenis_id' => '',
            'nominal' => null,
            'keterangan' => '',
        ]];
    }

    public function defaultLampiranItem()
    {
        return [
            'file' => null,
            'pelaksanaan_jenis_id' => '',
            'nominal' => null,
            'keterangan' => '',
        ];
    }

    public function removeLampiran($lampiran)
    {
        if (isset($lampiran['id'])) {
            Pelaksanaan::find($lampiran['id'])?->delete();
        }
    }

    public function savePelaksanaan($rencana_id, $lampirans, $tanggal_upload, $laporanJenisId)
    {
        foreach ($lampirans as $lampiran) {

            $filePath = null;
            $fileType = 'pdf';

            if (!empty($lampiran['file'])) {

                $file = $lampiran['file'];
                $extension = strtolower($file->getClientOriginalExtension());

                $fileType = in_array($extension, ['jpg','jpeg','png']) ? 'image' : 'pdf';

                $filePath = $file->store('pelaksanaan', 'public');

            } else {
                $filePath = $lampiran['file_existing'] ?? null;
            }

            $nominal = $lampiran['pelaksanaan_jenis_id'] == $laporanJenisId
                ? 0
                : ($lampiran['nominal'] ?? 0);

            Pelaksanaan::create([
                'rencana_id' => $rencana_id,
                'pelaksanaan_jenis_id' => $lampiran['pelaksanaan_jenis_id'],
                'nominal' => $nominal,
                'file_pdf' => $filePath,
                'file_type' => $fileType,
                'keterangan' => $lampiran['keterangan'],
                'tanggal_upload' => $tanggal_upload,
            ]);
        }
    }
}