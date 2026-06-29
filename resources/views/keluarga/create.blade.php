@extends('layouts.main')
{{-- @dd($rw->id) --}}
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
                            Tambah Data Penduduk
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
                        <h4 class="card-title">Multiple Column</h4>
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
                            <form class="form" action="{{ route('keluarga.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">No KK</label>
                                            <input type="NUMBER" id="first-name-column" class="form-control"
                                                placeholder="No KK" name="no_kk" value="{{ old('no_kk') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Kepala Keluarga</label>
                                            <select name="kepala_keluarga_id" class="form-select" id="select-penduduk"
                                                required>
                                                <option value="" selected>Pilih Penduduk</option>
                                                @foreach ($kepalaKeluarga as $d)
                                                    <option value="{{ $d->id }}"> {{ $d->nik }} -
                                                        {{ $d->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="country-floating">Alamat</label>
                                            <input type="text" id="country-floating" class="form-control" name="alamat"
                                                placeholder="Alamat" value="{{ old('alamat') }}">
                                        </div>
                                    </div>




                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rt-column">rt</label>
                                            <select name="rt_id" class="form-select" id="rt-column" required>
                                                <option value="" selected>Pilih RT</option>
                                                @foreach ($rt as $r)
                                                    <option value="{{ $r->id }}"> {{ $r->no_rt }}</option>
                                                @endforeach
                                            </select>

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
        flatpickr("#tanggal_lahir", {
            dateFormat: "Y-m-d",
        });
        flatpickr("#tanggal_kelahiran", {
            dateFormat: "Y-m-d",
        });
        flatpickr("#tanggal_pelaporan", {
            dateFormat: "Y-m-d",
        });

        $(document).ready(function() {
            $('#select-penduduk').selectize({
                placeholder: "Cari Penduduk...",
                allowEmptyOption: true
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            const mutasi = document.getElementById("mutasi");
            const formPindah = document.getElementById("form-pindah");
            const formLahir = document.getElementById("form-lahir");

            function toggleForm() {
                const value = mutasi.value;

                formPindah.style.display = "none";
                formLahir.style.display = "none";

                if (value === "pindah_masuk") {
                    formPindah.style.display = "block";
                } else if (value === "kelahiran") {
                    formLahir.style.display = "block";
                }
            }

            mutasi.addEventListener("change", toggleForm);

            // biar old() tetap jalan saat validation error
            toggleForm();
        });
    </script>
@endsection
