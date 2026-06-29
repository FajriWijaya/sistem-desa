@extends('layouts.main')

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data RW Dusun {{ $dusun->nama_dusun }}</h3>

            </div>

        </div>
    </div>

    <section class="section">

        <div class="card">
            <div class="card-header">List Semua RW</div>

            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="d-flex mb-3 me-4 justify-content-end">


                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#inlineForm">
                    Tambah RW
                </button>

                <div class="modal fade" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">Menamabh RW Baru</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="form" action="{{ route('dusun.rw.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">

                                            <input type="hidden" name="dusun_id" value="{{ $dusun->id }}" id="">

                                            <div class="mb-3">
                                                <label for="" class="form-label">No
                                                    RW</label>
                                                <input type="number" class="form-control" name="no_rw" id=""
                                                    aria-describedby="helpId" placeholder="" />
                                                <small id="helpId" class="form-text text-body-secondary">Help
                                                    text</small>
                                            </div>

                                        </div>
                                        <div class="col-12 col-md-6">

                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama
                                                    Ketua RW</label>
                                                <input type="text" class="form-control" name="ketua_rw" id=""
                                                    aria-describedby="helpId" placeholder="" />
                                                <small id="helpId" class="form-text text-body-secondary">Help
                                                    text</small>
                                            </div>

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
                            <th>No RW</th>
                            <th>Keteua RW</th>
                            <th>Jumlah Jumlah RT</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rw as $r)
                            <tr>
                                <td>{{ $r->no_rw }}</td>
                                <td>{{ $r->ketua_rw }}</td>
                                <td>{{ $r->rt->count() }}</td>
                                <td>
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('dusun.rw.rt', $r->id) }}" class="btn btn-primary btn-sm">Lihat RT</a>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#inlineForm-{{ $r->id }}">Edit</button>

                                        <div class="modal fade" id="inlineForm-{{ $r->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel33">Menamah RW Baruk</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="form" action="{{ route('dusun.rw.update', $r->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf

                                                        <div class="modal-body">
                                                            <div class="row g-2">
                                                                <div class="col-12 col-md-6">

                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">No RW</label>
                                                                        <input type="number" class="form-control"
                                                                            name="no_rw" id=""
                                                                            aria-describedby="helpId" placeholder=""
                                                                            value="{{ $r->no_rw }}" />
                                                                        <small id="helpId"
                                                                            class="form-text text-body-secondary">Help
                                                                            text</small>
                                                                    </div>

                                                                </div>
                                                                <div class="col-12 col-md-6">

                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Nama
                                                                            Ketua RW</label>
                                                                        <input type="text" class="form-control"
                                                                            name="ketua_rw" id=""
                                                                            aria-describedby="helpId" placeholder=""
                                                                            value="{{ $r->ketua_rw }}" />
                                                                        <small id="helpId"
                                                                            class="form-text text-body-secondary">Help
                                                                            text</small>
                                                                    </div>

                                                                </div>




                                                            </div>
                                                        </div>
                                                        <div class="modal-footer flex-wrap">
                                                            <button type="button" class="btn btn-light-secondary"
                                                                data-bs-dismiss="modal">
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

                                        <form id="delete-form-{{ $r->id }}"
                                            action="{{ route('dusun.rw.destroy', $r->id) }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="window.confirmDelete({{ $r->id }})" title="Hapus">

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
