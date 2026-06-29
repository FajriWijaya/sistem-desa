@extends('layouts.main')

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data RT RW {{ $rw->no_rw }}</h3>

            </div>

        </div>
    </div>

    <section class="section">

        <div class="card">
            <div class="card-header">List Semua RT</div>

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
                    Tambah RT
                </button>

                <div class="modal fade" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">Menambah RT Baruk</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="form" action="{{ route('dusun.rw.rt.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">

                                            <input type="hidden" name="rw_id" value="{{ $rw->id }}" id="">

                                            <div class="mb-3">
                                                <label for="" class="form-label">No
                                                    RT</label>
                                                <input type="number" class="form-control" name="no_rt" id=""
                                                    aria-describedby="helpId" placeholder="" />
                                                <small id="helpId" class="form-text text-body-secondary">Help
                                                    text</small>
                                            </div>

                                        </div>
                                        <div class="col-12 col-md-6">

                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama
                                                    Ketua RT</label>
                                                <input type="text" class="form-control" name="ketua_rt" id=""
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
                            <th>No RT</th>
                            <th>Keteua RT</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rt as $r)
                            <tr>
                                <td>{{ $r->no_rt }}</td>
                                <td>{{ $r->ketua_rt }}</td>
                                
                                <td>
                                    <div class="d-flex justify-content-end gap-1">

                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#inlineForm-{{ $r->id }}">Edit</button>

                                        <div class="modal fade" id="inlineForm-{{ $r->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel33">Menambah Dusun Baruk</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="form" action="{{ route('dusun.rw.rt.update', $r->id) }}"
                                                        method="POST">
                                                        @method('PUT')
                                                        @csrf

                                                        <div class="modal-body">
                                                            <div class="row g-2">
                                                                <div class="col-12 col-md-6">

                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">No RT</label>
                                                                        <input type="number" class="form-control"
                                                                            name="no_rt" id=""
                                                                            aria-describedby="helpId" placeholder=""
                                                                            value="{{ $r->no_rt }}" />
                                                                        <small id="helpId"
                                                                            class="form-text text-body-secondary">Help
                                                                            text</small>
                                                                    </div>

                                                                </div>
                                                                <div class="col-12 col-md-6">

                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Nama
                                                                            Ketua RT</label>
                                                                        <input type="text" class="form-control"
                                                                            name="ketua_rt" id=""
                                                                            aria-describedby="helpId" placeholder=""
                                                                            value="{{ $r->ketua_rt }}" />
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
                                            action="{{ route('dusun.rw.rt.destroy', $r->id) }}" method="POST"
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
