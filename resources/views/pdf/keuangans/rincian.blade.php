<h3 align="center">RINCIAN BIAYA PERJALANAN DINAS</h3>

<p>
<strong>{{ $keuangan->kegiatan }}</strong><br>
Tanggal {{ \Carbon\Carbon::parse($keuangan->tanggal_kegiatan)->format('d F Y') }}<br>
Tempat {{ $keuangan->lokasi_kegiatan }}
</p>

<table>
    <tr>
        <th>No</th>
        <th>Uraian</th>
        <th>Jumlah</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Transportasi Ranai (PP)</td>
        <td>Rp {{ number_format($keuangan->transportasi_ranai,0,',','.') }}</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Transport Bandara – Hotel (PP)</td>
        <td>Rp {{ number_format($keuangan->transportasi_bandara_hotel,0,',','.') }}</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Tiket Pesawat Udara (PP)</td>
        <td>Rp {{ number_format($keuangan->tiket_pesawat,0,',','.') }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Jumlah</strong></td>
        <td><strong>Rp {{ number_format($keuangan->jumlah,0,',','.') }}</strong></td>
    </tr>
</table>

<p><strong>Terbilang:</strong> {{ $keuangan->terbilang }}</p>
