@extends('layouts.main')

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Dusun</h3>

            </div>

        </div>
    </div>

    <section class="section">

        <div class="card">
            <div class="card-header">List Data Keluarga</div>

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
                    Tambah Dusun
                </button>

                <div class="modal fade" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">Menamah Dusun Baruk</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="form" action="{{ route('dusun.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">

                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Dusun</label>
                                                <input type="text" class="form-control" name="nama_dusun" id=""
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
                            <th>Nama Dusun</th>
                            <th>Jumlah RW</th>
                            <th>Jumlah RT</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dusun as $d)
                            <tr>
                                <td>{{ $d->nama_dusun }}</td>
                                <td>{{ $d->rw->count() }}</td>
                                <td>{{ $d->jumlah_rt }}</td>
                                <td>
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('dusun.rw', $d->id) }}" class="btn btn-primary btn-sm">Lihat RW</a>
                                        
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#inlineForm-{{ $d->id }}">Edit</button>

                                        <div class="modal fade" id="inlineForm-{{ $d->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel33" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel33">Menamah Dusun Baruk</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="form" action="{{ route('dusun.update', $d->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @method('PUT')
                                                        @csrf

                                                        <div class="modal-body">
                                                            <div class="row g-2">
                                                                <div class="col-12 col-md-6">

                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Nama
                                                                            Dusun</label>
                                                                        <input type="text" class="form-control"
                                                                            name="nama_dusun" id=""
                                                                            aria-describedby="helpId" placeholder="" value="{{ $d->nama_dusun }}"/>
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

                                        <form id="delete-form-{{ $d->id }}" action="{{ route('dusun.destroy', $d->id) }}" method="POST" style="display:none;">
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
