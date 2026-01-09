<h3 align="center">DAFTAR PENGELUARAN RIIL</h3>

<p>
Nama : .......................<br>
NIP  : .......................
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
</table>

<br><br>
<p align="right">
Yang membuat pernyataan,<br><br><br>
(........................)
</p>
