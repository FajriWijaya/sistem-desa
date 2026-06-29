@extends('layouts.main')
{{-- @dd($rw->id) --}}
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Kelahiran RW {{ $rw->no_rw }}</h3>

            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item " aria-current="page">
                            <a href="{{ route('kelahiran.rw', $rw->no_rw) }}">RW {{ $rw->no_rw }}</a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            Catat Data Kelahiran RW {{ $rw->no_rw }}
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
                        <h4 class="card-title">Pencatatan Kelahiran</h4>
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
                            <form class="form" action="{{ route('kelahiran.update', $kelahiran->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Tanggal Pelaporan</label>
                                            <input type="text" id="tanggal-pelaporan" class="form-control"
                                                placeholder="Tanggal Pelaporan" name="tanggal_pelaporan"
                                                value="{{ old('tanggal_pelaporan', $kelahiran->tanggal_pelaporan) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">NIK</label>
                                            <input type="NUMBER" id="first-name-column" class="form-control"
                                                placeholder="NIK" name="nik" value="{{ old('nik', $kelahiran->mutasiPenduduk->penduduk->nik) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">No KK</label>
                                            <select name="keluarga_id" id="no-kk" class="form-select">
                                                
                                                @foreach ($kk as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('keluarga_id', $kelahiran->keluarga_id ) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->no_kk }} - Keluarga
                                                        {{ $item->kepalaKeluarga->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Nama Lengkap</label>
                                            <input type="text" id="last-name-column" class="form-control"
                                                placeholder="Nama Lengkap" name="nama_lengkap"
                                                value="{{ old('nama_lengkap', $kelahiran->mutasiPenduduk->penduduk->nama_lengkap) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <select class="form-select" id="basicSelect" name="jenis_kelamin">
                                                <option value="">Jenis Kelamin</option>
                                                <option value="laki-laki"
                                                    {{ old('jenis_kelamin', $kelahiran->mutasiPenduduk->penduduk->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki
                                                </option>
                                                <option value="perempuan"
                                                    {{ old('jenis_kelamin', $kelahiran->mutasiPenduduk->penduduk->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="">Ibu</label>
                                            <select name="ibu_id" class="form-select" id="select-ibu">
                                               
                                                @foreach ($ibu as $d)
                                                    <option value="{{ $d->id }}"
                                                        {{ old('ibu_id', $kelahiran->ibu_id) == $d->id ? 'selected' : '' }}>
                                                        {{ $d->nik }} - {{ $d->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="">Ayah</label>
                                            <select name="ayah_id" class="form-select" id="select-ayah">
                                                <option value="" selected>Pilih Ayah</option>
                                                @foreach ($ayah as $d)
                                                    <option value="{{ $d->id }}"
                                                        {{ old('ayah_id', $kelahiran->ayah_id) == $d->id ? 'selected' : '' }}>
                                                        {{ $d->nik }} - {{ $d->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="text" id="tanggal_lahir" class="form-control"
                                                name="tanggal_lahir" placeholder="Tanggal Lahir"
                                                value="{{ old('tanggal_lahir', $kelahiran->tanggal_lahir) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Waktu Lahir</label>
                                            <input type="time" id="waktu_lahir" class="form-control"
                                                name="waktu_lahir" placeholder="Waktu Lahir"
                                                value="{{ old('waktu_lahir', $kelahiran->waktu_lahir) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" id="tempat_lahir" class="form-control"
                                                name="tempat_lahir" placeholder="Tempat Lahir"
                                                value="{{ old('tempat_lahir', $kelahiran->tempat_lahir) }}" required>
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

        flatpickr("#waktu_lahir", {
            enableTime: true,
            time_24hr: true,
            noCalendar: true,
            dateFormat: "H:i",
        });

        flatpickr("#tanggal_lahir", {
            dateFormat: "Y-m-d",
        });

        flatpickr("#tanggal-pelaporan", {
            dateFormat: "Y-m-d",
        });
    </script>
@endsection
