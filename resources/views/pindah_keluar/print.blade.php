<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penduduk Keluar</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 1.2cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #000;
        }

        .print-container {
            width: 100%;
        }

        /* HEADER */
        .report-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .report-header h1 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .report-header h2 {
            font-size: 12pt;
            font-weight: bold;
        }

        .report-header p {
            font-size: 10pt;
        }

        .header-line {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            margin: 8px 0 12px;
        }

        /* META */
        .report-meta {
            font-size: 9pt;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        /* FILTER */
        .filter-info {
            font-size: 9pt;
            margin-bottom: 10px;
        }

        /* TABLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 5px;
        }

        .data-table th {
            text-align: center;
            font-weight: bold;
        }

        .data-table td {
            vertical-align: middle;
        }

        .table-head {
            background: #f2f2f2;
        }

        .group-header {
            background: #e5e7eb;
            font-weight: bold;
        }

        /* ALIGN */
        .text-center { text-align: center; }
        .wrap-text { word-break: break-word; }

        .nik {
            font-family: monospace;
            font-size: 8pt;
        }

        /* SIGNATURE */
        .signature-area {
            margin-top: 40px;
            width: 100%;
        }

        .signature-box {
            width: 220px;
            float: right;
            text-align: center;
            font-size: 10pt;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
        }

        /* FOOTER */
        .print-note {
            margin-top: 30px;
            font-size: 8pt;
            text-align: center;
        }

        /* PRINT OPTIMIZATION */
        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

    </style>
</head>

<body>

<div class="print-container">

    <!-- HEADER -->
    <div class="report-header">
        <h1>PEMERINTAH KABUPATEN REMBANG</h1>
        <h2>KECAMATAN REMBANG</h2>
        <h2>DESA/KELURAHAN MONDOTEKO</h2> 
    </div>

    <div class="header-line"></div>

    <div class="report-header">
        <h1>LAPORAN PENDUDUK KELUAR</h1>
    </div>

    <!-- META -->
    <div class="report-meta">
        <div>
            <strong>Tanggal Cetak:</strong> {{ date('d/m/Y') }}
        </div>
        <div>
            <strong>Total Data:</strong> {{ $penduduk->count() }}
        </div>
    </div>

    <!-- FILTER -->
    @if (isset($klasifikasi) && $klasifikasi)
    <div class="filter-info">
        <strong>Filter Klasifikasi:</strong> {{ $klasifikasi }}
    </div>
    @endif

    <!-- TABLE -->
    <table class="data-table">
        <thead>
            <tr class="table-head">
                <th rowspan="2">No</th>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Klasifikasi</th>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama</th>
                <th colspan="3" class="group-header">ASAL</th>
                <th colspan="5" class="group-header">TUJUAN</th>
            </tr>
            <tr class="table-head">
                <th>Alamat</th>
                <th>RT</th>
                <th>RW</th>

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

                <td>{{ optional($item->perpindahan)->alamat_asal ?? '-' }}</td>
                <td class="text-center">{{ optional($item->perpindahan)->rt_asal ?? '-' }}</td>
                <td class="text-center">{{ optional($item->perpindahan)->rw_asal ?? '-' }}</td>

                <td>{{ optional($item->perpindahan)->alamat_tujuan ?? '-' }}</td>
                <td>{{ optional($item->perpindahan)->desa_tujuan ?? '-' }}</td>
                <td>{{ optional($item->perpindahan)->kecamatan_tujuan ?? '-' }}</td>
                <td>{{ optional($item->perpindahan)->kabupaten_tujuan ?? '-' }}</td>
                <td>{{ optional($item->perpindahan)->provinsi_tujuan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="13" class="text-center" style="padding: 30px;">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

  

    <!-- FOOTER -->
    <div class="print-note">
        Dokumen ini dicetak secara otomatis oleh sistem
    </div>

</div>


<script>
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>