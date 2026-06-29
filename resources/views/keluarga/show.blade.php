@extends('layouts.main')
{{-- @dd($keluarga) --}}
@section('content')
    @php
        $keluarga->loadMissing(['kepalaKeluarga', 'anggotaKeluarga.penduduk.rt.rw']);
    @endphp
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Data Keluarga RW {{ $rw->no_rw }}</h3>

            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item " aria-current="page">
                            <a href="{{ route('keluarga.rw') }}">RW</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            RW {{ $rw->no_rw }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-gradient bg-primary text-white border-0">
            <h4 class="mb-0 text-white">
                <i class="material-symbols-outlined">
                    family_restroom
                </i> Keluarga {{ $keluarga->kepalaKeluarga->nama_lengkap }}
            </h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">No KK</label>
                        <p class="fs-5 fw-semibold text-dark">{{ $keluarga->no_kk }}</p>
                    </div>
                    <div>
                        <label class="form-label fw-bold text-muted">Kepala Keluarga</label>
                        <p class="fs-5 fw-semibold text-dark">
                            {{ $keluarga->kepalaKeluarga->nama_lengkap }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Alamat</label>
                        <p class="fs-5 fw-semibold text-dark">
                            <i class="bi bi-geo-alt"></i>
                            {{ $keluarga->alamat }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <section class="section">

        <div class="card">
            <div class="card-header">List Data Anggota Keluarga</div>
            <div class="d-flex mb-3 me-4 justify-content-end">

                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#inlineForm">
                    Tambah Anggota Keluarga
                </button>

                {{-- <a href="{{ route('finance.print') }}" class="btn btn-lg btn-outline-info">
                              Print
                              <i class="fa-solid fa-print"></i>
                          </a> --}}

                {{-- <a href="{{ route('kategori_transaksi.index') }}" class="btn btn-primary">Buat kategori baru</a> --}}

            </div>

            <div class="modal fade" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Tambahkan Anggota Keluarga</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="form" action="{{ route('keluarga.anggota.store', $keluarga->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-12 col-md-6">
                                        <label for="nama_tagihan" class="form-label">Anggota Keluarga</label>
                                        <select name="penduduk_id" id="select-penduduk" required>
                                            <option value="" selected>Pilih Penduduk</option>
                                            @foreach ($penduduk as $d)
                                                <option value="{{ $d->id }}"> {{ $d->nik }} -
                                                    {{ $d->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="nominal" class="form-label">Hubungan</label>
                                        <select name="hubungan" class="form-select" id="">
                                            <option value="" selected>Pilih Hubungan</option>
                                            <option value="kepala keluarga">Kepala Keluarga</option>
                                            <option value="suami">Suami</option>
                                            <option value="istri">Istri</option>
                                            <option value="anak">Anak</option>
                                            <option value="cucu">Cucu</option>
                                            <option value="orang tua">Orang Tua</option>
                                        </select>
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

            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Hubungan</th>
                            <th>RT</th>
                            <th>RW</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keluarga->anggotaKeluarga as $k)
                            <tr>
                                <td>{{ $k->penduduk->nik }}</td>
                                <td>{{ $k->penduduk->nama_lengkap }}</td>
                                <td>{{ $k->hubungan }}</td>
                                <td>{{ $k->penduduk->rt->no_rt }}</td>
                                <td>{{ $k->penduduk->rt->rw->no_rw }}</td>

                                <td>
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="" class="btn btn-primary btn-sm">Lihat</a>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-id="{{ $k->id }}"
                                            data-penduduk="{{ $k->penduduk_id }}"
                                            data-hubungan="{{ $k->hubungan }}">Edit</button>

                                        <form id="delete-form-{{ $k->id }}"
                                            action="{{ route('keluarga.anggota.destroy', $k->id) }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="window.confirmDelete({{ $k->id }})" title="Hapus">
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

@section('script')
    <script>
        $(document).ready(function() {
            $('#select-penduduk').selectize({
                placeholder: "Cari Penduduk...",
                allowEmptyOption: true
            });
            $('.select-penduduks').selectize({
                placeholder: "Cari Penduduk...",
                allowEmptyOption: true
            });
        });
    </script>
@endsection
