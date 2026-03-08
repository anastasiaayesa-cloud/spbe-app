<?php

namespace App\Services\Pelaksanaan;

use App\Models\Rencana;

class PelaksanaanIndexService
{
    public function getAdminRencana()
    {
        return Rencana::with('pelaksanaans')
            ->orderBy('tanggal_kegiatan', 'desc')
            ->paginate(5);
    }

    public function getPegawaiRencana($kepegawaianId)
    {
        return Rencana::with(['pelaksanaans' => function ($q) use ($kepegawaianId) {
                $q->where('kepegawaian_id', $kepegawaianId);
            }])
            ->whereHas('kepegawaians', function ($q) use ($kepegawaianId) {
                $q->where('kepegawaians.id', $kepegawaianId);
            })
            ->orderBy('tanggal_kegiatan', 'desc')
            ->paginate(5);
    }
}