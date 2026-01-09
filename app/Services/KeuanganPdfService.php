<?php

namespace App\Services;

use App\Models\Keuangan;
use Barryvdh\DomPDF\Facade\Pdf;

class KeuanganPdfService
{
    /**
     * Generate PDF Keuangan (3 dokumen resmi)
     */
    public static function generate(Keuangan $keuangan)
    {
        return Pdf::loadView(
            'pdf.keuangans.master',
            [
                'keuangan' => $keuangan
            ]
        )->setPaper('A4', 'portrait');
    }
}
