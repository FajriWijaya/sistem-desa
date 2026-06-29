
@extends('layouts.main')

@section('content')
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
  
    <section class="section">

        <div class="card">
            <div class="card-header">List Data Keluarga</div>
            <div class="d-flex mb-3 me-4 justify-content-end">

                <a href="{{ route('keluarga.create', $rw->no_rw) }}" class="btn btn-outline-primary">
                    Tambah Keluarga
                </a>

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
                            <th>No KK</th>
                            <th>Nama Kepala Keluarga</th>
                            <th>Alamat</th>
                            <th>RT</th>
                            <th>RW</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keluarga as $k)
                            <tr>
                                <td>{{ $k->no_kk }}</td>
                                <td>{{ $k->kepalaKeluarga->nama_lengkap }}</td>
                                <td>{{ $k->alamat }}</td>
                                <td>{{ $k->rt->no_rt }}</td>
                                <td>{{ $k->rt->rw->no_rw }}</td>
                                <td>
                                       <td>
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('keluarga.show', $k->id) }}"
                                            class="btn btn-primary btn-sm">Detail</a>
                                        <a href="{{ route('keluarga.edit', $k->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form id="delete-form-{{ $k->id }}"
                                            action="{{ route('keluarga.destroy', $k->id) }}"
                                             method="POST"
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

