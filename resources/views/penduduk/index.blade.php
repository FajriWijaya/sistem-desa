@extends('layouts.main')

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Penduduk RW {{ $rw->no_rw }}</h3>

            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item " aria-current="page">
                            <a href="{{ route('penduduk.rw') }}">rw</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            RW {{ $rw->no_rw }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-heading">
        <div class="container-fluid">
            <div class="row g-4">

                {{-- CARD --}}
                @php
                    $cards = [
                        [
                            'title' => 'Jumlah Keluarga',
                            'value' => $jumlahKeluarga,
                            'icon' => 'bi-people',
                            'color' => 'success',
                        ],
                        [
                            'title' => 'Jumlah Penduduk',
                            'value' => $jumlahPenduduk,
                            'icon' => 'bi-people-fill',
                            'color' => 'primary',
                        ],
                        [
                            'title' => 'Kelahiran',
                            'value' => $jumlahPendudukLahir,
                            'icon' => 'bi-emoji-smile',
                            'color' => 'success',
                        ],
                        [
                            'title' => 'Kematian',
                            'value' => $jumlahPendudukMeninggal,
                            'icon' => 'bi-emoji-frown',
                            'color' => 'danger',
                        ],
                        [
                            'title' => 'Pindah Datang',
                            'value' => $jumlahPendudukPindahDatang,
                            'icon' => 'bi-person-plus',
                            'color' => 'success',
                        ],
                        [
                            'title' => 'Pindah Keluar',
                            'value' => $jumlahPendudukPindahKeluar,
                            'icon' => 'bi-person-dash',
                            'color' => 'danger',
                        ],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div class="col-md-6 col-lg-4">
                        <div class="card stat-card border-0 shadow-sm h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">

                                {{-- KIRI --}}
                                <div>
                                    <p class="text-muted mb-1 small">
                                        {{ $card['title'] }}
                                    </p>
                                    <h3 class="fw-bold mb-0">
                                        {{ $card['value'] }}
                                    </h3>
                                </div>

                                {{-- ICON --}}
                                <div class="icon-box bg-{{ $card['color'] }}">
                                    <i class="bi {{ $card['icon'] }}"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    @if (session('errors_import'))
        <div class="alert alert-danger">
            <ul>
                @foreach (session('errors_import') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="section">

        <div class="card">
            <div class="card-header">Simple Datatable</div>
            <div class="d-flex mb-3 me-4 justify-content-end gap-2">

                <a href="{{ route('penduduk.tambah', $rw->no_rw) }}" class="btn btn-outline-primary">
                    Tambah Penduduk
                </a>
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-file-import"></i>
                    </button>
                    <ul class="dropdown-menu p-3">
                        <li>
                            <button data-bs-toggle="modal" data-bs-target="#inlineForm" class="btn text-decoration-none">Import Axcel</button>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('penduduk.template') }}">Download Template</a></li>

                    </ul>
                </div>

                <div class="modal fade" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">Import Data Penduduk</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="form" action="{{ route('penduduk.import', $rw->no_rw) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">
                                            
                                            <input type="file" name="file" placeholder="Masukan File Axcel">
                                        </div>

                                        


                                    </div>
                                </div>
                                <div class="modal-footer flex-wrap">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                        <span>Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ms-1">
                                        <span>Tambahkan</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- <a href="{{ route('finance.print') }}" class="btn btn-lg btn-outline-info">
                              Print
                              <i class="fa-solid fa-print"></i>
                          </a> --}}

                {{-- <a href="{{ route('kategori_transaksi.index') }}" class="btn btn-primary">Buat kategori baru</a> --}}

            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Status Kependudukan</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penduduk as $d)
                            <tr>
                                <td>{{ $d->nik }}</td>
                                <td>{{ $d->nama_lengkap }}</td>
                                <td>{{ $d->jenis_kelamin }}</td>
                                <td>{{ $d->alamat }}</td>
                                <td>
                                    <span
                                        class="badge text-bg-{{ $d->status_kependudukan === 'aktif' ? 'success' : 'secondary' }}">
                                        {{ $d->status_kependudukan }}
                                    </span>
                                </td>
                                <td>{{ App\Models\MutasiPenduduk::where('penduduk_id', $d->id)->latest()->first()?->keterangan ?? 'Tidak catatan mutasi' }}
                                </td>

                                <td>
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('penduduk.show', $d->id) }}"
                                            class="btn btn-primary btn-sm">Lihat</a>
                                        <a href="{{ route('penduduk.edit', $d->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form id="delete-form-{{ $d->id }}"
                                            action="{{ route('penduduk.destroy', $d->id) }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="window.confirmDelete({{ $d->id }})" title="Hapus">

                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    </div>
@endsection
