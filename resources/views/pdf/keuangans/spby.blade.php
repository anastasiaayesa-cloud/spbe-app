<h3 align="center">SURAT PERINTAH BAYAR</h3>

<p>
Dibayarkan kepada : ......................<br>
Jumlah : <strong>Rp {{ number_format($keuangan->jumlah,0,',','.') }}</strong><br>
Terbilang : <strong>{{ $keuangan->terbilang }}</strong>
</p>

<p>
Untuk kegiatan {{ $keuangan->kegiatan }}<br>
Tanggal {{ \Carbon\Carbon::parse($keuangan->tanggal_kegiatan)->format('d F Y') }}<br>
Tempat {{ $keuangan->lokasi_kegiatan }}
</p>

<br><br>
<p align="right">
Pejabat Pembuat Komitmen<br><br><br>
(........................)
</p>
