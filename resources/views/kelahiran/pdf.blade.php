<style>
body {
    font-family: "Times New Roman", serif;
    font-size: 12px;
    margin: 30px;
    color: #000;
}

.header {
    text-align: center;
    margin-bottom: 20px;
}

.header h2 {
    margin: 0;
    font-size: 18px;
    text-transform: uppercase;
}

.header p {
    margin: 2px 0;
    font-size: 12px;
}

.line {
    border-top: 2px solid black;
    margin: 10px 0 20px 0;
}

.title {
    text-align: center;
    font-weight: bold;
    margin-bottom: 15px;
    font-size: 14px;
    text-transform: uppercase;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black;
    padding: 6px;
}

th {
    text-align: center;
    font-weight: bold;
}

td {
    vertical-align: middle;
}

.text-center {
    text-align: center;
}

.text-left {
    text-align: left;
}

.footer {
    margin-top: 40px;
    width: 100%;
}

.signature {
    width: 200px;
    float: right;
    text-align: center;
}

.signature p {
    margin: 5px 0;
}
</style>

<div class="header">
   <h1>PEMERINTAH KABUPATEN REMBANG</h1>
    <h2>KECAMATAN REAMBANG</h2>
    <h2>DESA/KELURAHAN MONDOTEKO</h2>
</div>

<div class="line"></div>

<div class="title">
    LAPORAN DATA KELAHIRAN PENDUDUK
</div>

<table>
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Tgl Lapor</th>
            <th rowspan="2">No KK</th>
            <th colspan="4">Identitas Anak</th>
            <th rowspan="2">Nama Ayah</th>
            <th rowspan="2">Nama Ibu</th>
            <th colspan="3">Alamat</th>
        </tr>
        <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>Tgl Lahir</th>
            <th>L/P</th>
            <th>Alamat</th>
            <th>RT</th>
            <th>RW</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($kelahiran as $item)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $item->tanggal_pelaporan }}</td>
            <td class="text-center">{{ $item->mutasiPenduduk->penduduk->keluarga->no_kk }}</td>
            <td>{{ $item->mutasiPenduduk->penduduk->nik ?? 'N/A' }}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <td class="text-center">{{ $item->tanggal_lahir }}</td>
            <td class="text-center">{{ $item->jenis_kelamin }}</td>
            <td>{{ $item->ayah->nama_lengkap }}</td>
            <td>{{ $item->ibu->nama_lengkap }}</td>
            <td>{{ $item->mutasiPenduduk->penduduk->alamat ?? 'N/A' }}</td>
            <td class="text-center">{{ $item->mutasiPenduduk->penduduk->rt->no_rt ?? 'N/A' }}</td>
            <td class="text-center">{{ $item->mutasiPenduduk->penduduk->rt->rw->no_rw ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    <div class="signature">
        <p>Mugassari, {{ date('d M Y') }}</p>
        <p>Kepala Desa</p>

        <br><br><br>

        <p><b>(Nama Kepala Desa)</b></p>
    </div>
</div>