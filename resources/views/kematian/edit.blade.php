@extends('layouts.main')
{{-- @dd($rw->id) --}}
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Kematian RW {{ $rw->no_rw }}</h3>

            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item " aria-current="page">
                            <a href="">RW {{ $rw->no_rw }}</a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            Catat Data Kematian RW {{ $rw->no_rw }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pencatatan Kematian</h4>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" action="{{ route('kematian.update', $kematian->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Tanggal Pelaporan</label>
                                            <input type="text" id="tanggal-pelaporan" class="form-control"
                                                placeholder="Tanggal Pelaporan" name="tanggal_pelaporan"
                                                value="{{ old('tanggal_pelaporan', $kematian->tanggal_pelaporan) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Tanggal Kematian</label>
                                            <input type="text" id="tanggal-kematian" class="form-control"
                                                placeholder="Tanggal Kematian" name="tanggal_kematian"
                                                value="{{ old('tanggal_kematian', $kematian->tanggal_kematian) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Waktu Kematian</label>
                                            <input type="text" id="waktu-kematian" class="form-control"
                                                placeholder="Waktu Kematian" name="waktu_kematian"
                                                value="{{ old('waktu_kematian', $kematian->waktu_kematian) }}" required>
                                        </div>
                                    </div>
                                    

                                  
  
                                </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end mb-2 me-2">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#select-penduduk').selectize({
                placeholder: "Cari Penduduk...",
                allowEmptyOption: true
            });
        });

        flatpickr("#waktu-kematian", {
            enableTime: true,
            time_24hr: true,
            noCalendar: true,
            dateFormat: "H:i",
        });

        flatpickr("#tanggal-kematian", {
            dateFormat: "Y-m-d",
        });

        flatpickr("#tanggal-pelaporan", {
            dateFormat: "Y-m-d",
        });
    </script>
@endsection
