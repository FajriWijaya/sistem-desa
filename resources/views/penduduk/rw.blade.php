@extends('layouts.main')

@section('content')

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 mb-3 order-last ">
      <h3>Kepundukan Dusun</h3>
      <p class="text-subtitle text-muted">
       
      </p>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav
        aria-label="breadcrumb"
        class="breadcrumb-header float-start float-lg-end"
      >
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.html">Dashboard</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Dusun
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
     <div class="page-heading">
          <section class="section">
            <div class="card">
              <div class="card-header">List Data Kpendudukan Dusun</div>
              <div class="card-body">
                <table class="table table-striped" id="table1">
                  <thead>
                    <tr>
                      <th>RW</th>
                      <th>Dusun</th>
                      <th>Jumlah Penduduk</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                 <tbody>
                    @foreach ($rw as $d)
                      <tr>
                        <td>{{ $d->no_rw }}</td>
                        <td>{{ $d->dusun->nama_dusun }}</td>
                        <td>{{ $d->jumlah_penduduk }}</td>
                        <td>
                          <a href="{{ route('penduduk.index', $d->id) }}" class="btn btn-primary">Lihat</a>
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