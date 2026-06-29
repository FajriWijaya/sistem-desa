<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penduduk</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #f0f0f0;
        }

        .text-left {
            text-align: left;
        }

        .total {
            font-weight: bold;
            background: #eaeaea;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="no-print" style="margin-bottom:20px;">
        <button onclick="window.print()">Print</button>
    </div>

    <h2>LAPORAN MUTASI PENDUDUK</h2>
    <h4>
        Bulan {{ \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F') }}
        Tahun {{ $tahun }}
    </h4>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Dusun</th>

                <th colspan="3">Awal</th>
                <th colspan="3">Lahir</th>
                <th colspan="3">Datang</th>
                <th colspan="3">Meninggal</th>
                <th colspan="3">Pindah</th>
                <th colspan="3">Akhir</th>
            </tr>

            <tr>
                <th>L</th>
                <th>P</th>
                <th>Jml</th>

                <th>L</th>
                <th>P</th>
                <th>Jml</th>

                <th>L</th>
                <th>P</th>
                <th>Jml</th>

                <th>L</th>
                <th>P</th>
                <th>Jml</th>

                <th>L</th>
                <th>P</th>
                <th>Jml</th>

                <th>L</th>
                <th>P</th>
                <th>Jml</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($data as $i => $d)
                <tr>

                    <td>{{ $i + 1 }}</td>

                    <td class="text-left">
                        {{ $d->nama_dusun }}
                    </td>

                    {{-- AWAL --}}
                    <td>{{ $d->awal_l }}</td>
                    <td>{{ $d->awal_p }}</td>
                    <td>{{ $d->total_awal }}</td>

                    {{-- LAHIR --}}
                    <td>{{ $d->lahir_l }}</td>
                    <td>{{ $d->lahir_p }}</td>
                    <td>{{ $d->lahir_l + $d->lahir_p }}</td>

                    {{-- DATANG --}}
                    <td>{{ $d->datang_l }}</td>
                    <td>{{ $d->datang_p }}</td>
                    <td>{{ $d->datang_l + $d->datang_p }}</td>

                    {{-- MENINGGAL --}}
                    <td>{{ $d->meninggal_l }}</td>
                    <td>{{ $d->meninggal_p }}</td>
                    <td>{{ $d->meninggal_l + $d->meninggal_p }}</td>

                    {{-- PINDAH --}}
                    <td>{{ $d->pindah_l }}</td>
                    <td>{{ $d->pindah_p }}</td>
                    <td>{{ $d->pindah_l + $d->pindah_p }}</td>

                    {{-- AKHIR --}}
                    <td>{{ $d->akhir_l }}</td>
                    <td>{{ $d->akhir_p }}</td>
                    <td>{{ $d->total_akhir }}</td>

                </tr>
            @endforeach

            <tr class="total">

                <td colspan="2">TOTAL</td>

                {{-- AWAL --}}
                <td>{{ $data->sum('awal_l') }}</td>
                <td>{{ $data->sum('awal_p') }}</td>
                <td>{{ $data->sum('total_awal') }}</td>

                {{-- LAHIR --}}
                <td>{{ $data->sum('lahir_l') }}</td>
                <td>{{ $data->sum('lahir_p') }}</td>
                <td>{{ $data->sum('lahir_l') + $data->sum('lahir_p') }}</td>

                {{-- DATANG --}}
                <td>{{ $data->sum('datang_l') }}</td>
                <td>{{ $data->sum('datang_p') }}</td>
                <td>{{ $data->sum('datang_l') + $data->sum('datang_p') }}</td>

                {{-- MENINGGAL --}}
                <td>{{ $data->sum('meninggal_l') }}</td>
                <td>{{ $data->sum('meninggal_p') }}</td>
                <td>{{ $data->sum('meninggal_l') + $data->sum('meninggal_p') }}</td>

                {{-- PINDAH --}}
                <td>{{ $data->sum('pindah_l') }}</td>
                <td>{{ $data->sum('pindah_p') }}</td>
                <td>{{ $data->sum('pindah_l') + $data->sum('pindah_p') }}</td>

                {{-- AKHIR --}}
                <td>{{ $data->sum('akhir_l') }}</td>
                <td>{{ $data->sum('akhir_p') }}</td>
                <td>{{ $data->sum('total_akhir') }}</td>

            </tr>

        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>