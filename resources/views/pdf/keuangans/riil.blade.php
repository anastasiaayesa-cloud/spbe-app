@include('pdf.partials.kop-surat')
<h3 class="text-center">DAFTAR PENGELUARAN RIIL</h3>

<p>
Yang bertandatangan di bawah ini:<br>
Nama : {{ $pegawai->nama ?? '-' }}<br>
NIP : {{ $pegawai->nip ?? '-' }}<br>
Pangkat/Golongan : {{ $pegawai->pangkat ?? '-' }}<br>
Jabatan : {{ $pegawai->jabatan ?? '-' }}<br>
Unit Kerja : {{ $pegawai->unit_kerja ?? '-' }}
</p>

<p>
Berdasarkan Surat Perintah Perjalanan Dinas (SPPD)<br>
Nomor : {{ $keuangan->no_sppd }}<br>
Tanggal : {{ \Carbon\Carbon::parse($keuangan->tanggal_kegiatan)->translatedFormat('d F Y') }}
</p>

<p>
    1. Biaya transport pegawai perjalanan dinas di UPT di bawah ini yang tidak dapat diperoleh 
bukti – bukti pengeluaran, meliputi : 
</p>

<table>
    <tr>
        <th>No</th>
        <th>Uraian</th>
        <th>Jumlah</th>
    </tr>
    @php
    $total = 0;
    $no = 1;
@endphp

@foreach (
    $keuangan->pelaksanaan->rencana->pelaksanaans ?? []
    as $item
)
    @php $total += $item->nominal; @endphp
    <tr>
        <td class="text-center">{{ $no++ }}</td>
        <td>{{ $item->jenis->nama }}</td>
        <td class="text-right">
            Rp {{ number_format($item->nominal, 0, ',', '.') }}
        </td>
    </tr>
@endforeach

<tr>
    <td colspan="2"><strong>Jumlah</strong></td>
    <td class="text-right">
        <strong>
            Rp {{ number_format($keuangan->total_nominal, 0, ',', '.') }}
        </strong>
    </td>
</tr>

</table>

<p>
    2. Jumlah uang tersebut di atas benar – benar dikeluarkan untuk pelaksanaan perjalanan dinas 
dimaksud dan apabila di kemudian hari terdapat kelebihan atas pembayaran, kami bersedia 
untuk menyetorkan kelebihan tersebut ke Kas Negara. 
</p>

<p>
Demikian pernyataan ini kami buat dengan sebenarnya.
</p>

<br>

<table class="no-border" width="100%">
<tr class="no-border">
<td class="no-border">
Mengetahui / Menyetujui<br>
Pejabat Pembuat Komitmen,<br><br><br><br><br><br>
<strong>Richardon Sinaga, S.Si., M.Pd</strong><br>
NIP. 197809292003121004
</td>

<td class="no-border text-right">
Yang melakukan perjalanan dinas,<br><br><br><br><br><br>
<strong>{{ $pegawai->nama ?? '-' }}</strong><br>
NIP. {{ $pegawai->nip ?? '-' }}
</td>
</tr>
</table>
