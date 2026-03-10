<style>
    body {
        font-family: "Times New Roman", Times, serif;
        font-size: 11pt;
        line-height: 1.5;
    }

    @page {
        margin: 3cm 3cm 3cm 3cm;
    }

    h3 {
        font-size: 12pt;
        font-weight: bold;
        text-align: center;
        margin: 20px 0 15px 0;
        text-decoration: underline;
    }

    p {
        margin: 6px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 11pt;
    }
        /* Menghilangkan garis horizontal antar item di dalam body */
    .table-bersih tbody td {
        border-top: none !important;
        border-bottom: none !important;
    }

    /* Munculkan garis bawah hanya pada item terakhir agar tabel tertutup */
    .table-bersih tbody tr.item-terakhir td {
        border-bottom: 0.5pt solid #000 !important;
    }

    /* Baris footer (Jumlah & Terbilang) tetap pakai border normal */
    .table-bersih tr.footer td {
        border: 0.5pt solid #000 !important;
    }

    th, td {
        border: 0.5pt solid #000;
        padding: 6px 6px;
        vertical-align: top;
    }

    th {
        text-align: center;
        font-weight: normal;
    }

    .text-center { text-align: center; }
    .text-right { text-align: right; }

    .no-border,
    .no-border td {
        border: none !important;
    }

    hr.solid {
        border: 0;
        border-top: 1px solid #000;
        margin: 15px 0;
    }

    .ttd-space {
        height: 70px;
    }
</style>


<h3>RINCIAN BIAYA PERJALANAN DINAS</h3>

<p class="text-center">
    Kegiatan {{ $keuangan->pelaksanaan->rencana->first()->nama_kegiatan ?? '-' }}<br>
    Pada tanggal {{ \Carbon\Carbon::parse($keuangan->tanggal_kegiatan)->translatedFormat('d F Y') }} di {{ $keuangan->pelaksanaan->rencana->lokasi_kegiatan ?? '-' }}
</p>

<p>
    <span style="display:inline-block; width:160px;">
        Lampiran SPPD Nomor
    </span>
    :
    {{ $keuangan->pelaksanaan->rencana->perencanaans->first()->no_sppd ?? '-' }}
    <br>

    <span style="display:inline-block; width:160px;">
        Tanggal
    </span>
    :
    {{ \Carbon\Carbon::parse($keuangan->tanggal_sppd)->translatedFormat('d F Y') }}
</p>

<table class="table-bersih">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Perincian Biaya</th>
            <th width="25%">Jumlah</th>
            <th width="20%">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp

        @foreach ($items as $index => $item)
            @php $total += $item->nominal; @endphp
            {{-- Class 'item-terakhir' otomatis muncul hanya di baris paling bawah @foreach --}}
            <tr class="{{ $loop->last ? 'item-terakhir' : '' }}">
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->pelaksanaanJenis->nama ?? '-' }}</td>
                <td class="text-right">
                    Rp. {{ number_format($item->nominal, 0, ',', '.') }}
                </td>
                <td></td>
            </tr>
        @endforeach

        {{-- JUMLAH --}}
        <tr class="footer">
            <td colspan="2" class="text-right">Jumlah</td>
            <td class="text-right">
                Rp {{ number_format($total, 0, ',', '.') }}
            </td>
            <td></td>
        </tr>

        {{-- TERBILANG --}}
        <tr class="footer">
            <td colspan="4">
                Terbilang :
                <strong><em>
                    {{ ucfirst(terbilang(angka: $total)) }} Rupiah
                </em></strong>
            </td>
        </tr>
    </tbody>
</table>


<table class="no-border">
    <tr class="no-border">
        <td class="no-border">
            Telah dibayar sejumlah<br>
            Rp {{ number_format($total, 0, ',', '.') }}<br>
            Bendahara Pengeluaran,<br><br>
            <div class="ttd-space"></div>
            Pujo Santoso, S.T.<br>
            NIP. 199002172015041001
        </td>

        <td class="no-border" style="text-align: left; vertical-align: top; width: 50%; padding-left: 80px;">
    {{ $keuangan->tempat_ttd ?? 'Bintan' }}, 
    {{ \Carbon\Carbon::parse($keuangan->tanggal_ttd)->translatedFormat('d F Y') }}<br>
    Telah menerima uang sebesar,<br>
    Rp {{ number_format($total, 0, ',', '.') }}<br>
    Yang menerima uang,
    <div class="ttd-space"></div>
    {{ $pegawai->nama ?? '-' }}<br>
    NIP. {{ $pegawai->nip ?? '-' }}
</td>
    </tr>
</table>

<hr style="border: 0; border-top: 1px dashed #000;">

<table class="no-border">
    <tr>
        <td colspan="2" class="text-center">
            PERHITUNGAN SPPD RAMPUNG
        </td>
    </tr>
</table>

<table class="no-border" width="100%">
    <tr>
        <!-- KIRI -->
        <td width="60%" valign="top">
            <table class="no-border" width="100%">
                <tr>
    <td style="padding:0; line-height:1.2;">
        Ditetapkan sejumlah<span style="display:inline-block; width:77px;"></span>:
        <br>
        Rp {{ number_format($total, 0, ',', '.') }}
    </td>
</tr>

<tr>
    <td style="padding:0; line-height:1.2;">
        Yang telah dibayarkan semula<span style="display:inline-block; width:20px;"></span>:
        <br>
        Rp {{ number_format($total, 0, ',', '.') }}
    </td>
</tr>

<tr>
    <td style="padding:0; line-height:1.2;">
        Sisa kurang / lebih<span style="display:inline-block; width:89px;"></span>: NIHIL
    </td>
</tr>

            </table>
        </td>

        <!-- KANAN -->
         <td class="no-border" style="text-align: left; vertical-align: top; width: 50%; padding-left: 55px;">
            Pejabat Pembuat Komitmen,<br>
            <div class="ttd-space"></div>
            Richardon Sinaga, S.Si., M.Pd<br>
            NIP. 197809292003121004
        </td>
    </tr>
</table>
