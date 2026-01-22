@include('pdf.partials.kop-surat')
<h3 class="text-center">SURAT PERINTAH BAYAR</h3>

<p>
Tanggal : {{ \Carbon\Carbon::parse($keuangan->tanggal_ttd)->translatedFormat('d F Y') }}<br>
Nomor : {{ $keuangan->no_spby }}
</p>
@php $total = 0; @endphp

<table width="100%" border="1" cellspacing="0" cellpadding="8" style="border-collapse: collapse; font-size: 12px;">
    <tr>
        <td>
            Saya yang bertandatangan di bawah ini selaku Pejabat Pembuat Komitmen,
            memerintahkan Bendahara Pengeluaran agar melakukan pembayaran sejumlah :
            <br><br>
<strong>
            Rp {{ number_format($keuangan->total_nominal, 0, ',', '.') }}
        </strong>    </tr>

    <tr>
        <td>
<strong>
            Terbilang :
            {{ ucfirst(terbilang($keuangan->total_nominal)) }} rupiah
        </strong>        </td>
    </tr>

    <tr>
        <td>
            <table width="100%" cellpadding="4" cellspacing="0">
                <tr>
                    <td width="25%">Kepada</td>
                    <td width="5%">:</td>
                    <td>{{ $pegawai->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Untuk Pembayaran</td>
                    <td>:
                    <td>
                        {{ $keuangan->kegiatan }}
                        Tanggal {{ \Carbon\Carbon::parse($keuangan->tanggal_kegiatan)->translatedFormat('d F Y') }} <br>
                        di {{ $keuangan->lokasi_kegiatan }}
                    </td>
                </tr>
            </table>

            <br>

            <strong>Atas dasar :</strong><br>
            1. Kuitansi / bukti pembelian   :<br>
            2. Nota / bukti penerimaan Barang/Jasa (bukti lainnya)  :

            <br><br>

            <table width="100%" cellpadding="4" cellspacing="0">
                <tr>
                    <td width="40%">Dibebankan pada :</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Kegiatan, Output, MAK :</td>
                    <td> {{ $keuangan->mak ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Kode :</td>
                    <td> {{ $keuangan->kode ?? '-' }}</td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td>
            <table width="100%" cellspacing="0" cellpadding="4">
                <tr>
                    <td width="33%" align="center">
                        Lunas dibayar,<br>
                        Tanggal {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                        Bendahara Pengeluaran<br><br><br><br><br><br><br>
                        <strong>Pujo Santoso, S.T.</strong><br>
                        NIP. 199002172015041001
                    </td>

                    <td width="33%" align="center">
                        Diterima Tanggal<br>
                        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                        Penerima Uang/Uang Muka Kerja<br><br><br><br><br><br><br>
                        <strong>{{ $pegawai->nama ?? '-' }}</strong><br>
                        NIP. {{ $pegawai->nip ?? '-' }}
                    </td>

                    <td width="33%" align="center">
                        {{"Batam "}},
                        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                        a.n. Kuasa Pengguna Anggaran<br>
                        Pejabat Pembuat Komitmen<br><br><br><br><br><br><br>
                        <strong>Richardon Sinaga, S.Si., M.Pd</strong><br>
                        NIP. 197809292003121004
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

