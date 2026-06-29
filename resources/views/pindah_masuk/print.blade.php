<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Perpindahan Penduduk</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 1.5cm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11pt;
            color: #000;
        }

        .container {
            width: 100%;
        }

        /* ===== KOP ===== */
        .kop {
            text-align: center;
            line-height: 1.4;
        }

        .kop h1 {
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .kop h2 {
            font-size: 14pt;
            font-weight: bold;
        }

        .kop p {
            font-size: 11pt;
        }

        .line {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            margin: 8px 0 15px;
        }

        /* ===== JUDUL ===== */
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        /* ===== META ===== */
        .meta {
            width: 100%;
            margin-bottom: 10px;
            font-size: 10pt;
        }

        .meta td {
            padding: 2px 4px;
        }

        /* ===== TABLE ===== */
        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 5px;
        }

        table.data th {
            text-align: center;
            font-weight: bold;
        }

        table.data td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .nik {
            font-family: monospace;
            font-size: 9pt;
        }

        /* ===== TTD ===== */
        .ttd {
            margin-top: 40px;
            width: 100%;
        }

        .ttd td {
            text-align: center;
            padding-top: 40px;
        }

        .nama {
            margin-top: 60px;
            border-top: 1px solid #000;
            display: inline-block;
            padding-top: 3px;
            width: 200px;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 20px;
            font-size: 9pt;
            text-align: center;
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

<div class="container">

    <!-- KOP SURAT -->
    <div class="kop">
        <h1>PEMERINTAH KABUPATEN REMBANG</h1>
        <h2>KECAMATAN REMBANG</h2>
        <h2>DESA/KELURAHAN MONDOTEKO</h2>
        <p>
            Dusun {{ strtoupper($rw->dusun->nama_dusun) }} RW {{ strtoupper($rw->no_rw) }}
        </p>
    </div>

    <div class="line"></div>

    <!-- JUDUL -->
    <div class="judul">
        LAPORAN PERPINDAHAN PENDUDUK
    </div>

    <!-- META -->
    <table class="meta">
        <tr>
            <td width="70%">Periode : Semua Data</td>
            <td>Tanggal Cetak : {{ date('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Total Data : {{ $penduduk->count() }}</td>
            <td></td>
        </tr>
    </table>

    <!-- TABLE -->
    <table class="data">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Klasifikasi</th>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Pekerjaan</th>
                <th colspan="4">TUJUAN</th>
                <th colspan="5">ASAL</th>
            </tr>
            <tr>
                <th>Alamat</th>
                <th>RT</th>
                <th>RW</th>
                <th>Desa</th>
                <th>Alamat</th>
                <th>Desa</th>
                <th>Kecamatan</th>
                <th>Kabupaten</th>
                <th>Provinsi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($penduduk as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>

                <td class="text-center">
                    {{ optional($item->perpindahan)->tanggal_pelaporan
                        ? \Carbon\Carbon::parse($item->perpindahan->tanggal_pelaporan)->format('d/m/Y')
                        : '-' }}
                </td>

                <td>{{ optional($item->perpindahan)->klasifikasi_perpindahan ?? '-' }}</td>

                <td class="nik">{{ optional($item->penduduk)->nik ?? '-' }}</td>

                <td>{{ optional($item->penduduk)->nama_lengkap ?? '-' }}</td>

                <td>{{ optional($item->penduduk)->profesi ?? '-' }}</td>

                <td>{{ optional($item->perpindahan)->alamat_tujuan ?? '-' }}</td>
                <td class="text-center">{{ optional($item->perpindahan)->rt_tujuan ?? '-' }}</td>
                <td class="text-center">{{ optional($item->perpindahan)->rw_tujuan ?? '-' }}</td>
                <td>{{ optional($item->perpindahan)->desa_tujuan ?? '-' }}</td>

                <td>{{ optional($item->perpindahan)->alamat_asal ?? '-' }}</td>
                <td>{{ optional($item->perpindahan)->desa_asal ?? '-' }}</td>
                <td>{{ optional($item->perpindahan)->kecamatan_asal ?? '-' }}</td>
                <td>{{ optional($item->perpindahan)->kabupaten_asal ?? '-' }}</td>
                <td>{{ optional($item->perpindahan)->provinsi_asal ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="15" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

  

    <!-- FOOTER -->
    <div class="footer">
        Dokumen ini dicetak otomatis oleh sistem
    </div>

</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>