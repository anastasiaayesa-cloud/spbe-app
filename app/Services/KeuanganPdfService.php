<?php

namespace App\Services;

use App\Models\Keuangan;
use App\Models\Pelaksanaan;
use Barryvdh\DomPDF\Facade\Pdf;

class KeuanganPdfService
{
    public static function generate(Keuangan $keuangan, $pegawai)
    {
        // ambil pelaksanaan KHUSUS pegawai ini
        $items = Pelaksanaan::with('pelaksanaanJenis')
            ->where('rencana_id', $keuangan->pelaksanaan->rencana_id)
            ->where('kepegawaian_id', $pegawai->id) // ✅ FIX DI SINI
            ->get();

        return Pdf::loadView('pdf.keuangans.master', [
            'keuangan' => $keuangan,
            'pegawai'  => $pegawai,
            'items'    => $items,
            'total'    => $items->sum('nominal'),
        ])->setPaper('A4', 'portrait');
    }
}
