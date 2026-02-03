<!-- JUDUL -->
<h3>SURAT PERINTAH BAYAR</h3>

<!-- TANGGAL & NOMOR -->
<div style="font-size:11pt; margin-bottom:6px;">
    <strong>Tanggal : {{ \Carbon\Carbon::parse($keuangan->tanggal_ttd)->translatedFormat('d F Y') }}<br></strong>
    <strong>Nomor : {{ $keuangan->no_spby }}</strong>
</div>

<!-- ISI UTAMA -->
<table width="100%" border="1" cellspacing="0" cellpadding="5"
       style="border-collapse:collapse; font-size:11pt; line-height:1.50;">

    <tr>
        <td>
            Saya yang bertandatangan di bawah ini selaku Pejabat Pembuat Komitmen,
            memerintahkan Bendahara Pengeluaran agar melakukan pembayaran sejumlah:
            <br>
            <strong>
                Rp. {{ number_format($items->sum('nominal'), 0, ',', '.') }}
            </strong>        </td>
    </tr>

    <tr>
    <td style="padding: 12px 0;">
        <strong>
            Terbilang :
            <em>{{ ucfirst(terbilang(angka: $items->sum('nominal'))) }} Rupiah</em>
        </strong>
    </td>
</tr>


    <tr>
        <td>
            <div style="display: table; width: 100%; margin-bottom: 10px;">
    <div style="display: table-row;">
        <div style="display: table-cell; width: 120px; vertical-align: top;">Kepada</div>
        <div style="display: table-cell; width: 10px; vertical-align: top;">:</div>
        <div style="display: table-cell; vertical-align: top;">{{ $pegawai->nama ?? '-' }}</div>
    </div>
</div>

<div style="display: table; width: 100%; margin-bottom: 10px;">
    <div style="display: table-row;">
        <div style="display: table-cell; width: 120px; vertical-align: top;">Untuk Pembayaran</div>
        <div style="display: table-cell; width: 10px; vertical-align: top;">:</div>
        <div style="display: table-cell; vertical-align: top; text-align: justify;">
            Kegiatan {{ $keuangan->pelaksanaan->rencana->first()->nama_kegiatan ?? '-' }},
            Tanggal {{ \Carbon\Carbon::parse($keuangan->tanggal_kegiatan)->translatedFormat('d F Y') }}
            di {{ $keuangan->pelaksanaan->rencana->first()->lokasi_kegiatan ?? '-' }}
        </div>
    </div>
</div>

            <div style="margin-top: 10px;">
    <div style="margin-top: 10px;">
    Atas dasar :
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 5px; border: none !important;">
    <tr>
        <td style="width: 40px; vertical-align: top; border: none !important; padding: 2px 0 2px 20px;">1.</td>
        <td style="width: 240px; vertical-align: top; border: none !important; padding: 2px 0;">Kuitansi / bukti pembelian</td>
        <td style="width: 15px; vertical-align: top; border: none !important; padding: 2px 0;">:</td>
        <td style="vertical-align: top; border: none !important; padding: 2px 0;">
            {{-- Isi bukti pembelian --}}
        </td>
    </tr>
    
    <tr>
        <td style="vertical-align: top; border: none !important; padding: 2px 0 2px 20px;">2.</td>
        <td style="vertical-align: top; border: none !important; padding: 2px 0;">Nota / bukti penerimaan Barang/Jasa (bukti lainnya)</td>
        <td style="vertical-align: top; border: none !important; padding: 2px 0;">:</td>
        <td style="vertical-align: top; border: none !important; padding: 2px 0;">
            {{-- Isi nota --}}
        </td>
    </tr>
</table>
</div>

            <br><br>

<div style="margin-top: 10px;">
    Dibebankan pada:
    <table style="width: 100%; border-collapse: collapse; margin-top: 5px; border: none !important;">
        <tr>
            <td style="width: 160px; vertical-align: top; border: none !important; padding: 2px 0;">Kegiatan, Output, MAK</td>
            <td style="width: 15px; vertical-align: top; border: none !important; padding: 2px 0;">:</td>
            <td style="vertical-align: top; border: none !important; padding: 2px 0;">
                {{ $keuangan->mak ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; border: none !important; padding: 2px 0;">Kode</td>
            <td style="vertical-align: top; border: none !important; padding: 2px 0;">:</td>
            <td style="vertical-align: top; border: none !important; padding: 2px 0;">
                {{ $keuangan->kode ?? '-' }}
            </td>
        </tr>
    </table>
</div>
    </tr>

    <tr>
    <td valign="top" style="padding:0; margin:0;">
        <table width="100%" cellspacing="0"
               style="border:none; font-size:11pt; line-height:1.25;">
            <tr>

                <!-- KIRI -->
                <td width="33%" valign="top" align="left"
                    style="border:none; padding:0 8px;">
                    
                    <div style="margin-top:-11px;">
                        Lunas dibayar,<br>
                        Tanggal <br>
                        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                        Bendahara Pengeluaran
                    </div>
                    <br>
                    <div style="height:60px;"></div>

                    <strong>Pujo Santoso, S.T.</strong><br>
                    NIP. 199002172015041001
                </td>

                <!-- TENGAH -->
                <td width="33%" valign="top" align="left"
                    style="border:none; padding:0 8px;">
                    
                    <div style="margin-top:-11px;">
                        Diterima Tanggal<br>
                        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                        Penerima Uang/Uang Muka Kerja
                    </div>
                    <br>

                    <div style="height:60px;"></div>

                    <strong>{{ $pegawai->nama ?? '-' }}</strong><br>
                    NIP. {{ $pegawai->nip ?? '-' }}
                </td>

                <!-- KANAN -->
                <td width="33%" valign="top" align="left"
                    style="border:none; padding:0 8px;">
                    
                    <div style="margin-top:-11px;">
                        Batam, 
                        <br>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                        a.n. Kuasa Pengguna Anggaran<br>
                        Pejabat Pembuat Komitmen
                    </div>

                    <div style="height:60px;"></div>

                    <strong>Richardon Sinaga, S.Si., M.Pd</strong><br>
                    NIP. 197809292003121004
                </td>

            </tr>
        </table>
    </td>
</tr>



</table>
