<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>

        @page {
    size: A4 portrait;
    margin: 3cm 3cm 2cm 3cm;
}

body {
    margin: 0;
    padding: 0;
    font-family: "Times New Roman", Times, serif;
    font-size: 11pt;
    line-height: 1.1;
}

/* ===== KOP FIXED (UKURAN IKUT YANG LAMA) ===== */
.kop-fixed {
    position: fixed;
    top: -2.8cm; /* Sesuaikan agar tidak terpotong tepi kertas atas */
    left: 0;
    /* Jangan gunakan right: 0, biarkan lebar mengikuti kontainer */
    width: 100%; 
}

/* Pastikan tabel di dalam kop tidak punya margin bawaan yang mengganggu */
.kop-wrap table {
    width: 100%;
    border-collapse: collapse;
    border: none !important;
}

.kop-logo,
.kop-clear {
    display: none; /* sudah tidak dipakai */
}

.kop-logo img {
    width: 90px;          /* IKUT LAMA */
    display: block;
    margin: 0 auto;
}

.kop-text {
    text-align: center;
}

.kop-text .atas {
    font-size: 12pt;
    font-weight: bold;
    line-height: 1.2;     /* IKUT LAMA */
}
.kop-text .bawah {
    font-size: 12pt;
    font-weight: ;
    line-height: 1.2;     /* IKUT LAMA */
    margin-bottom: 6px;
}

.kop-text .alamat {
    font-size: 10pt;
    margin-top: 4px;      /* IKUT LAMA */
    line-height: 1.3;     /* IKUT LAMA */
}



.kop-line-1 {
    border: 0;
    border-top: 3px solid #000;
    margin: 0;
}

.safe-top {
    padding-top: 4px;
}
/* ===== KONTEN DITURUNKAN ===== */
.content {
    margin-top: 0.5cm;
}


        /* ===============================
           UTILITAS
        =============================== */
        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .text-justify{ text-align: justify; }
        .bold        { font-weight: bold; }

        .page-break {
            page-break-after: always;
        }

        /* ===============================
           HEADER INSTANSI
        =============================== */
        .instansi {
            text-align: center;
            line-height: 1.1;
        }

        .instansi .atas {
            font-size: 12pt;
            font-weight: bold;
        }

        .instansi .alamat {
            font-size: 10pt;
            font-weight: normal;
        }

        /* ===============================
           JUDUL DOKUMEN
        =============================== */
        .judul {
    font-size: 13pt;
    font-weight: bold;
    text-align: center;
    margin: 8px 0 10px 0;
}

        /* ===============================
           PARAGRAF
        =============================== */
        p {
            margin: 0 0 12px 0;
            text-align: justify;
        }

        /* ===============================
           TABEL
        =============================== */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5pt;
            margin-top: 10px;
        }

        table, th, td {
            border: 0.5pt solid #000;
        }

        th {
            font-weight: bold;
            text-align: center;
        }

        th, td {
            padding: 5px;
            vertical-align: top;
        }

        .no-border {
            border: none !important;
        }

        /* ===============================
           TANDA TANGAN
        =============================== */
        .ttd {
            margin-top: 40px;
            width: 100%;
        }

        .ttd td {
            border: none;
            vertical-align: top;
        }
    </style>
</head>

<body>

    @php
    $total = isset($total)
        ? $total
        : ($items->sum('nominal') ?? 0);
@endphp

    <div class="kop-fixed">
    <div class="kop-wrap">
        <table width="100%" class="no-border">
            <tr>
                <td width="95" align="center" valign="middle">
                    <img src="{{ public_path('image/logo/lambang-logo-logo-depdiknas-wuri-handayani-10.png') }}"
                         width="90">
                </td>
                <td align="center">
                    <div class="kop-text">
                        <div class="bawah">
                            KEMENTERIAN PENDIDIKAN, KEBUDAYAAN<br>
                            RISET, DAN TEKNOLOGI
                        </div>
                        <div class="atas">
                            BALAI PENJAMINAN MUTU PENDIDIKAN<br>
                            PROVINSI KEPULAUAN RIAU
                        </div>
                        <div class="alamat">
                            Jalan Tata Bumi Km 20 Ceruk Ijuk, Toapaya, Bintan, Kepulauan Riau 29153<br>
                            Telepon (0771) 4442196 Laman https://bpmpkepri.kemdikbud.go.id
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <hr class="kop-line-1">
</div>


<div class="content">


    {{-- ================= RINCIAN BIAYA ================= --}}
    @include('pdf.keuangans.rincian', [
        'keuangan' => $keuangan,
        'pegawai'  => $pegawai,
        'items'    => $items,
        'total'    => $total,
    ])

    <div class="page-break"></div>

    <div class="content">
    {{-- ================= DAFTAR PENGELUARAN RIIL ================= --}}
    @include('pdf.keuangans.riil', [
        'keuangan' => $keuangan,
        'pegawai'  => $pegawai,
        'items'    => $items,
        'total'    => $total,
    ])

    <div class="page-break"></div>

    <div class="content">
    {{-- ================= SURAT PERINTAH BAYAR ================= --}}
    @include('pdf.keuangans.spby', [
        'keuangan' => $keuangan,
        'pegawai'  => $pegawai,
        'items'    => $items,
        'total'    => $total,
    ])

</body>
</html>
