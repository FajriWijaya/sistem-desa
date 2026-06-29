@extends('layouts.main')

@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="material-symbols-outlined">
                                                family_restroom
                                            </i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">
                                            Jumlah Keluarga
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ $jumlahKeluarga }}
                                        </h6>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="fa-solid fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">
                                            Jumlah Penduduk
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ $jumlahPenduduk->sum('jumlah_penduduk') }}
                                        </h6>

                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm text-decoration-none">RW</button>
                                            <button type="button"
                                                class="btn text-decoration-none dropdown-toggle dropdown-toggle-split"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach ($jumlahPenduduk as $p)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('penduduk.index', $p->dusun->id) }}">
                                                            {{ $p->dusun->nama_dusun }} RW {{ $p->no_rw }} :
                                                            {{ $p->jumlah_penduduk }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        {{-- @foreach ($jumlahPenduduk as $rw => $count)
                                                    <a href="{{ route('penduduk', $rw) }}" class="link-opacity-10-hover mb">
                                                        RW {{ $rw }} : {{ $count }}

                                                    </a>
                                                @endforeach --}}


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="fa-solid fa-baby"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">
                                            Kelahiran
                                        </h6>
                                        <h6 class="font-extrabold mb-0">{{ $kelahiran->sum('jumlah_kelahiran') }}</h6>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm text-decoration-none">RW</button>
                                            <button type="button"
                                                class="btn text-decoration-none dropdown-toggle dropdown-toggle-split"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach ($kelahiran as $p)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('kelahiran', $p->dusun->id) }}">
                                                            {{ $p->dusun->nama_dusun }} RW {{ $p->no_rw }} :
                                                            {{ $p->jumlah_kelahiran }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="fa-solid fa-user-xmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Kematian</h6>
                                        <h6 class="font-extrabold mb-0">{{ $kematian->sum('jumlah_kematian') }}</h6>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm text-decoration-none">RW</button>
                                            <button type="button"
                                                class="btn text-decoration-none dropdown-toggle dropdown-toggle-split"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach ($kematian as $p)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('kematian', $p->dusun->id) }}">
                                                            {{ $p->dusun->nama_dusun }} RW {{ $p->no_rw }} :
                                                            {{ $p->jumlah_kematian }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="fa-solid fa-user-plus"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Pindah Masuk</h6>
                                        <h6 class="font-extrabold mb-0">{{ $perpindahanDatang->sum('jumlah_penduduk') }}
                                        </h6>

                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm text-decoration-none">RW</button>
                                            <button type="button"
                                                class="btn text-decoration-none dropdown-toggle dropdown-toggle-split"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach ($perpindahanDatang as $pm)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('pindah_masuk', $pm->dusun->id) }}">
                                                            {{ $pm->dusun->nama_dusun }} RW {{ $pm->no_rw }} :
                                                            {{ $pm->jumlah_penduduk }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="fa-solid fa-user-minus"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Pindah Keluar</h6>
                                        <h6 class="font-extrabold mb-0">{{ $perpindahanKeluar->sum('jumlah_penduduk') }}
                                        </h6>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm text-decoration-none">RW</button>
                                            <button type="button"
                                                class="btn text-decoration-none dropdown-toggle dropdown-toggle-split"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach ($perpindahanKeluar as $pk)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('pindah_keluar', $pk->dusun->id) }}">
                                                            {{ $pk->dusun->nama_dusun }} RW {{ $pk->no_rw }} :
                                                            {{ $pk->jumlah_penduduk }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Persentase Penduduk</h4>
                                <select id="filterChartPenduduk" class="form-select w-auto">
                                    <option value="bulan">Per Bulan</option>
                                    <option value="tahun">Per Tahun</option>
                                </select>
                            </div>
                            <div class="card-body">
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Mutasi Penduduk</h4>
                                <select id="filterMutasi" class="form-select w-auto">
                                    <option value="bulan">Per Bulan</option>
                                    <option value="tahun">Per Tahun</option>
                                </select>
                            </div>
                            <div class="card-body">
                                <div id="chart-mutasi"></div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="col-12 col-lg-3">


                <div class="card">
                    <div class="card-header">
                        <h4>Gender Penduduk</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-visitors-profile"></div>
                    </div>
                </div>



            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {

            // ===================== CHART MUTASI =====================
            const res = await fetch("{{ route("chartMutasi") }}");
            const data = await res.json();

            function buildSeries(src) {
                return [{
                        name: 'Kelahiran',
                        data: src.series.kelahiran
                    },
                    {
                        name: 'Meninggal',
                        data: src.series.meninggal
                    },
                    {
                        name: 'Pindah Masuk',
                        data: src.series.masuk
                    },
                    {
                        name: 'Pindah Keluar',
                        data: src.series.keluar
                    }
                ];
            }

            let chartMutasi = new ApexCharts(document.querySelector("#chart-mutasi"), {
                chart: {
                    type: 'bar',
                    height: 420,
                    stacked: false,
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 700
                    }
                },

                series: buildSeries(data.bulan),

                colors: ['#28a745', '#dc3545', '#0d6efd', '#ffc107'],

                plotOptions: {
                    bar: {
                        borderRadius: 3,
                        columnWidth: '76%',
                        distributed: false
                    }
                },

                dataLabels: {
                    enabled: false // ❗ biar tidak numpuk
                },

                stroke: {
                    width: 2,
                    colors: ['transparent']
                },

                xaxis: {
                    categories: data.bulan.labels,
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },

                yaxis: {
                    title: {
                        text: 'Jumlah'
                    }
                },

                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                },

                grid: {
                    borderColor: '#e0e0e0',
                    strokeDashArray: 4
                },

                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " orang";
                        }
                    }
                }
            });

            chartMutasi.render();

            document.getElementById('filterMutasi').addEventListener('change', function() {
                const src = this.value === 'tahun' ? data.tahun : data.bulan;

                chartMutasi.updateOptions({
                    series: buildSeries(src),
                    xaxis: {
                        categories: src.labels
                    }
                });
            });

            // ===================== CHART PENDUDUK =====================
            const response = await fetch('{{ route("chartData") }}');
            const result = await response.json();

            let chartPenduduk = new ApexCharts(document.querySelector("#chart"), {
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Penduduk Aktif',
                    data: result.bulan
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                        'Nov', 'Des'
                    ]
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                dataLabels: {
                    enabled: true
                },
                markers: {
                    size: 4
                }
            });

            chartPenduduk.render();

            document.getElementById('filterChartPenduduk').addEventListener('change', function() {
                if (this.value === 'tahun') {
                    chartPenduduk.updateOptions({
                        series: [{
                            data: result.tahun
                        }],
                        xaxis: {
                            categories: result.labelTahun
                        }
                    });
                } else {
                    chartPenduduk.updateOptions({
                        series: [{
                            data: result.bulan
                        }],
                        xaxis: {
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu',
                                'Sep', 'Okt', 'Nov', 'Des'
                            ]
                        }
                    });
                }
            });

        });
    </script>
@endsection
