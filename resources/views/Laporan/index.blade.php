@extends('layouts.main')

{{-- @dd($bulan, $tahun) --}}

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="page-heading">
                <h3>Laporan Penduduk Bulan {{ Carbon\Carbon::createFromFormat('m', $bulan)->format('F') }} Tahun {{ $tahun }}</h3>
            </div>
            <section class="section">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Filter</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laporan') }}" method="get">
                            @csrf
                            <div class="row g-3">

                                {{-- Filter Tanggal --}}
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Tahun</label>
                                    <select name="tahun" class="form-select" id="">
                                        <option value="" selected>Pilih Tahun</option>
                                        @for ($i = date('Y'); $i >= 2000; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Bulan</label>
                                    <select name="bulan" class="form-select" id="">
                                        <option value="" selected>Pilih Bulan</option>
                                        @foreach (range(1, 12) as $b)
                                            <option value="{{ $b }}">
                                                {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}</option>
                                        @endforeach
                                    </select>
                                </div>





                                {{-- Tombol Filter --}}
                                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                    <a href="" class="btn btn-secondary">
                                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                                    </a>
                                    <button class="btn btn-primary px-4" type="submit">
                                        <i class="bi bi-funnel"></i> Filter
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <section class="section">

        <div class="card">
            <div class="card-header">List Data Kematian</div>
            <div class="d-flex mb-3 me-4 justify-content-end gap-2">


                <a href="{{ route('laporan.print', ["bulan"=>$bulan,"tahun"=>$tahun]) }}" target="_blank" class="btn btn-outline-info">
                    <i class="fa-solid fa-print"></i>
                </a>

                <a href="" class="btn btn-outline-danger">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>





                {{-- <a href="{{ route('finance.print') }}" class="btn btn-lg btn-outline-info">
                Print
                <i class="fa-solid fa-print"></i>
            </a> --}}

                {{-- <a href="{{ route('kategori_transaksi.index') }}" class="btn btn-primary">Buat kategori baru</a> --}}

            </div>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
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
                            @for ($i = 0; $i < 6; $i++)
                                <th>L</th>
                                <th>P</th>
                                <th>Jml</th>
                            @endfor
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $index => $d)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start">{{ $d->nama_dusun }}</td>

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
                    </tbody>

                    {{-- TOTAL SEMUA --}}
                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td colspan="2">TOTAL</td>

                            <td>{{ $data->sum('awal_l') }}</td>
                            <td>{{ $data->sum('awal_p') }}</td>
                            <td>{{ $data->sum('total_awal') }}</td>

                            <td>{{ $data->sum('lahir_l') }}</td>
                            <td>{{ $data->sum('lahir_p') }}</td>
                            <td>{{ $data->sum('lahir_l') + $data->sum('lahir_p') }}</td>

                            <td>{{ $data->sum('datang_l') }}</td>
                            <td>{{ $data->sum('datang_p') }}</td>
                            <td>{{ $data->sum('datang_l') + $data->sum('datang_p') }}</td>

                            <td>{{ $data->sum('meninggal_l') }}</td>
                            <td>{{ $data->sum('meninggal_p') }}</td>
                            <td>{{ $data->sum('meninggal_l') + $data->sum('meninggal_p') }}</td>

                            <td>{{ $data->sum('pindah_l') }}</td>
                            <td>{{ $data->sum('pindah_p') }}</td>
                            <td>{{ $data->sum('pindah_l') + $data->sum('pindah_p') }}</td>

                            <td>{{ $data->sum('akhir_l') }}</td>
                            <td>{{ $data->sum('akhir_p') }}</td>
                            <td>{{ $data->sum('total_akhir') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
    </div>
@endsection

@section('script')
    {{-- <script>
    flatpickr("#tanggal_pelaporan", {
        dateFormat: "Y-m-d",
        mode: 'range',
    });
    flatpickr("#tanggal_kematian", {
        dateFormat: "Y-m-d",
        mode: 'range',
    });
</script> --}}
@endsection
