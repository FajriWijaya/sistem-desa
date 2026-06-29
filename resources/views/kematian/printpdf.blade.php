<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Kematian Penduduk</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 1cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11pt;
            color: #000;
        }

        /* ===== KOP ===== */
        .kop-wrapper {
            width: 100%;
            margin-bottom: 10px;
        }

        .kop-table {
            width: 100%;
        }

        .kop-logo {
            width: 80px;
        }

        .kop-logo img {
            width: 70px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h1 {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text h2 {
            font-size: 14pt;
            font-weight: bold;
        }

        .kop-text p {
            font-size: 11pt;
        }

        .garis-kop {
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            margin: 6px 0 12px 0;
        }

        /* ===== JUDUL ===== */
        .judul {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        /* ===== INFO ===== */
        .info {
            font-size: 10pt;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            text-align: center;
            font-weight: bold;
            background: #f2f2f2;
        }

        td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .nik {
            font-family: monospace;
            font-size: 9pt;
        }

        /* ===== TANDA TANGAN ===== */
        .ttd {
            margin-top: 40px;
            width: 100%;
        }

        .ttd-kanan {
            width: 250px;
            float: right;
            text-align: center;
            font-size: 11pt;
        }

        .ttd-line {
            margin-top: 60px;
            border-top: 1px solid black;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9pt;
        }

        /* ===== PRINT FIX ===== */
        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <!-- ===== KOP ===== -->
    <div class="kop-wrapper">
        <table class="kop-table">
            <tr>
                
                <td class="kop-text">
                    <h1>PEMERINTAH KABUPATEN REMBANG</h1>
                    <h2>KECAMATAN REAMBANG</h2>
                    <h2>DESA/KELURAHAN MONDOTEKO</h2>
                    <p>Alamat: Jl. XXXXX No. XX, Telp: XXXXX</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="garis-kop"></div>

    <!-- ===== JUDUL ===== -->
    <div class="judul">
        LAPORAN DATA KEMATIAN PENDUDUK
    </div>

    <!-- ===== INFO ===== -->
    <div class="info">
        <div>
            <strong>Tanggal Cetak:</strong> {{ date('d/m/Y') }}
        </div>
        <div>
            <strong>Total Data:</strong> {{ count($data) }}
        </div>
    </div>

    <!-- ===== TABLE ===== -->
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">No KK</th>
                <th colspan="5">DATA JENAZAH</th>
                <th rowspan="2">Pekerjaan</th>
                <th rowspan="2">Umur</th>
                <th colspan="3">ALAMAT DOMISILI</th>
            </tr>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tgl Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Tgl Meninggal</th>
                <th>Alamat</th>
                <th>RT</th>
                <th>RW</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($data as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->mutasiPenduduk->penduduk->keluarga->no_kk }}</td>

                <td class="nik">{{ $item->mutasiPenduduk->penduduk->nik }}</td>
                <td>{{ $item->MutasiPenduduk->penduduk->nama_lengkap }}</td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($item->mutasiPenduduk->penduduk->tanggal_lahir)->format('d/m/Y') }}
                </td>
                <td class="text-center">{{ $item->mutasiPenduduk->penduduk->jenis_kelamin }}</td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($item->tanggal_kematian)->format('d/m/Y') }}
                </td>

                <td>{{ $item->mutasiPenduduk->penduduk->profesi }}</td>
                <td class="text-center">{{ Carbon\Carbon::parse($item->mutasiPenduduk->penduduk->tanggal_lahir)->age }}</td>

                <td>{{ $item->mutasiPenduduk->penduduk->alamat }}</td>
                <td class="text-center">{{ $item->mutasiPenduduk->penduduk->rt->no_rt }}</td>
                <td class="text-center">{{ $item->mutasiPenduduk->penduduk->rt->rw->no_rw }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="text-center" style="padding:20px;">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ===== TANDA TANGAN ===== -->
  
    <!-- ===== FOOTER ===== -->
    <div class="footer">
        Dokumen ini dicetak secara otomatis oleh sistem
    </div>

</body>
</html>