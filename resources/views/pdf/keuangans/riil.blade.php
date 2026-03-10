<style>
    /* Menghilangkan garis antar baris di tabel ini */
.table-riil tbody td {
    border-top: none !important;
    border-bottom: none !important;
}

/* Memberi garis bawah pada baris terakhir daftar agar tabel tertutup sebelum JUMLAH */
.table-riil tbody tr.baris-akhir td {
    border-bottom: 0.5pt solid #000 !important;
}

/* Baris Header dan Footer tetap memiliki garis penuh */
.table-riil thead th,
.table-riil .row-footer td {
    border: 0.5pt solid #000 !important;
}
</style>

<h3 class="text-center">D A F T A R  P E N G E L U A R A N  R I I L</h3>

<p>
Yang bertandatangan di bawah ini:<br>
<span style="display:inline-block; width:150px;">Nama</span> : {{ $pegawai->nama ?? '-' }}<br>
<span style="display:inline-block; width:150px;">NIP</span> : {{ $pegawai->nip ?? '-' }}<br>
<span style="display:inline-block; width:150px;">Pangkat / Golongan</span> : {{ $pegawai->pangkat_id ?? '-' }}<br>
<span style="display:inline-block; width:150px;">Jabatan</span> : {{ $pegawai->jabatan ?? '-' }}<br>
<span style="display:inline-block; width:150px;">Unit Kerja</span> : {{ $pegawai->instansi_id ?? '-' }}
</p>

<p>
Berdasarkan Surat Perintah Perjalanan Dinas (SPPD) Tanggal : {{ \Carbon\Carbon::parse($keuangan->tanggal_kegiatan)->translatedFormat('d F Y') }}
<br>
Nomor : {{ $keuangan->no_sppd }}. Dengan ini, kami menyatakan dengan sesungguhnya bahwa: <br>
</p>
<div style="margin-bottom: 20px;"></div>
<ol style="padding-left: 20px; margin: 0;">
    <li style="margin-bottom: 10px;">
        Biaya transport pegawai perjalanan dinas di UPT di bawah ini yang tidak dapat diperoleh 
        bukti–bukti pengeluaran, meliputi:
    </li>
</ol>


<table class="table-riil" style="width: 95%; margin-left: auto; margin-right: 0;">
    <thead>
        <tr>
            <th width="5%" style="font-weight:bold; font-style:italic;">NO</th>
            <th style="font-weight:bold; font-style:italic;">URAIAN KEGIATAN</th>
            <th width="30%" style="font-weight:bold; font-style:italic;">JUMLAH</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp

        @foreach ($items as $index => $item)
            @php $total += $item->nominal; @endphp
            {{-- Tambahkan class 'baris-akhir' jika ini adalah data terakhir dalam loop --}}
            <tr class="{{ $loop->last ? 'baris-akhir' : '' }}">
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->pelaksanaanJenis->nama ?? '-' }}</td>
                <td class="text-right">
                    Rp. {{ number_format($item->nominal, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach

        {{-- BARIS JUMLAH --}}
        <tr class="row-footer">
            <td colspan="2" style="font-weight:bold; font-style:italic; text-align:center;">
                JUMLAH
            </td>
            <td class="text-right">
                <strong>
                    Rp {{ number_format($total, 0, ',', '.') }}
                </strong>
            </td>
        </tr>
    </tbody>
</table>

<p style="margin-left: 20px; text-indent: -20px;">
    2. Jumlah uang tersebut di atas benar – benar dikeluarkan untuk pelaksanaan perjalanan dinas 
dimaksud dan apabila di kemudian hari terdapat kelebihan atas pembayaran, kami bersedia 
untuk menyetorkan kelebihan tersebut ke Kas Negara. 
</p>
<div style="margin-bottom: 20px;"></div>

<p>
Demikian pernyataan ini kami buat dengan sebenarnya, untuk dipergunakan sebagaimana 
mestinya. 
</p>

<br>

<table class="no-border" width="100%">
<tr class="no-border">
<td class="no-border">
Mengetahui / Menyetujui<br>
Pejabat Pembuat Komitmen,<br><br><br><br><br>
Richardon Sinaga, S.Si., M.Pd<br>
NIP. 197809292003121004
</td>

<td class="no-border" style="text-align: left; vertical-align: top; width: 50%; padding-left: 70px;">
Pejabat Negara/ PegawaiNegeri<br>
Yang melakukan perjalanan dinas,<br><br><br><br><br>
{{ $pegawai->nama ?? '-' }}<br>
NIP. {{ $pegawai->nip ?? '-' }}
</td>
</tr>
</table>
