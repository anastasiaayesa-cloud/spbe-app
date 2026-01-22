@include('pdf.partials.kop-surat')
<h3 class="text-center">RINCIAN BIAYA PERJALANAN DINAS</h3>

<p class="text-center">
    {{-- <strong>{{ $keuangan->kegiatan }}</strong><br> --}}Kegiatan {{ $keuangan->pelaksanaan->rencana->first()->nama_kegiatan ?? '-'}}<br>
    Pada tanggal {{ \Carbon\Carbon::parse($keuangan->tanggal_kegiatan)->translatedFormat('d F Y') }}<br>
    di {{ $keuangan->lokasi_kegiatan }}
</p>

<p>
    Lampiran SPPD Nomor : {{ $keuangan->pelaksanaan->rencana->perencanaans->first()->no_sppd ?? '' }}<br>
    Tanggal : {{ \Carbon\Carbon::parse($keuangan->tanggal_sppd)->translatedFormat('d F Y') }}
</p>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Perincian Biaya</th>
            <th width="30%">Jumlah</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
@php $total = 0; @endphp

@forelse (
    $keuangan->pelaksanaan->rencana->pelaksanaans ?? collect()
    as $index => $item
)
    @php $total += $item->nominal; @endphp
    <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td>{{ $item->jenis->nama }}</td>
        <td class="text-right">
            Rp {{ number_format($item->nominal, 0, ',', '.') }}
        </td>
        <td></td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">
            <em>Belum ada biaya pelaksanaan</em>
        </td>
    </tr>
@endforelse

<tr>
    <td colspan="2"><strong>Jumlah</strong></td>
    <td class="text-right">
        <strong>
            Rp {{ number_format($keuangan->total_nominal, 0, ',', '.') }}
        </strong>    </td>
    <td></td>
</tr>

</tbody>

</table>

<p>
    <strong>Terbilang :   <strong>{{ ucfirst(terbilang(angka: $total)) }} rupiah</strong>
</p>

<br>

<table class="no-border" width="100%">
    <tr class="no-border">
        <td class="no-border">
            Telah dibayar sejumlah<br>
        <strong>
            Rp {{ number_format($keuangan->total_nominal, 0, ',', '.') }}
        </strong>            Bendahara Pengeluaran,<br><br><br>
            <strong>Pujo Santoso, S.T.</strong><br>
            NIP. 199002172015041001
        </td>
        <td class="no-border text-right">
            {{ $keuangan->tempat_ttd ?? 'Bintan' }},
            {{ \Carbon\Carbon::parse($keuangan->tanggal_ttd)->translatedFormat('d F Y') }}<br>
            Yang menerima uang,<br><br><br>
            <strong>{{ $pegawai->nama ?? '-' }}</strong><br>
            NIP. {{ $pegawai->nip ?? '-' }}
        </td>
    </tr>
</table>

            <hr style="border:0;border-top:1px dashed #000;">

<table width="100%" cellpadding="4" cellspacing="0" style="font-size:12px;">
    <tr>
        <td colspan="2" align="center">
            <strong>PERHITUNGAN SPPD RAMPUNG</strong>
            <hr style="border:0;border-top:1px dashed #000;">
        </td>
    </tr>

    <tr>
        <!-- KIRI -->
        <td width="60%" valign="top">
            <table width="100%" cellpadding="3" cellspacing="0">
                <tr>
                    <td width="45%">Ditetapkan sejumlah</td>
                    <td width="5%">:</td>
                    <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <td>Yang telah dibayarkan semula</td>
                    <td>:</td>
                    <td>Rp. </td>
                </tr>
                <tr>
                    <td>Sisa kurang / lebih</td>
                    <td>:</td>
                    <td><strong>NIHIL</strong></td>
                </tr>
            </table>
        </td>

        <!-- KANAN -->
        <td width="40%" valign="top" align="center">
            Pejabat Pembuat Komitmen,<br><br><br><br>
            <strong>Richardon Sinaga, S.Si., M.Pd</strong><br>
            NIP. 197809292003121004
        </td>
    </tr>
</table>