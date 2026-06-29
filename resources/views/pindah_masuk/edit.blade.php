@extends('layouts.main')
{{-- @dd($rt); --}}
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Penduduk RW {{ $perpindahan->rw_tujuan }}</h3>

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
                            Catat Data Penduduk Masuk
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
                            <form class="form" action="{{ route('pindah_masuk.update', $perpindahan->id) }}"
                                method="POST">
                                @method('put')
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Penduduk</label>
                                            <select name="penduduk_id" id="select-penduduk" required>
                                                <option value="" selected>Pilih Penduduk</option>
                                                <option selected>{{ $perpindahan->mutasiPenduduk->penduduk->nik }} -
                                                    {{ $perpindahan->mutasiPenduduk->penduduk->nama_lengkap }}</option>
                                                @foreach ($penduduk as $d)
                                                    <option value="{{ $d->id }}"> {{ $d->nik }} -
                                                        {{ $d->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Tanggal Pelaporan</label>
                                            <input type="text" id="tanggal-pelaporan" class="form-control"
                                                placeholder="Tanggal Pelaporan" name="tanggal_pelaporan"
                                                value="{{ old('tanggal_pelaporan', $perpindahan->tanggal_pelaporan) }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <select name="klasifikasi" class="form-select" required>

                                                <option value="antar desa/kelurahan dalam satu kecamatan"
                                                    {{ old('klasifikasi', $perpindahan->klasifikasi) == 'antar desa/kelurahan dalam satu kecamatan' ? 'selected' : '' }}>
                                                    antar
                                                    desa/kelurahan dalam satu kecamatan</option>
                                                <option value="pindah dalam satu desa/kelurahan"
                                                    {{ old('klasifikasi', $perpindahan->klasifikasi) == 'pindah dalam satu desa/kelurahan' ? 'selected' : '' }}>
                                                    pindah dalam satu
                                                    desa/kelurahan</option>
                                                <option value="antar kecamatan dalam satu kabupaten/kota"
                                                    {{ old('klasifikasi', $perpindahan->klasifikasi) == 'antar kecamatan dalam satu kabupaten/kota' ? 'selected' : '' }}>
                                                    antar kecamatan
                                                    dalam satu kabupaten/kota</option>
                                                <option value="antar kabupaten/kota dalam satu provinsi"
                                                    {{ old('klasifikasi', $perpindahan->klasifikasi) == 'antar kabupaten/kota dalam satu provinsi' ? 'selected' : '' }}>
                                                    antar
                                                    kabupaten/kota dalam satu provinsi</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="country-floating">Alamat Tujuan</label>
                                            <input type="text" id="country-floating" class="form-control"
                                                name="alamat_tujuan" placeholder="Alamat Tujuan"
                                                value="{{ old('alamat_tujuan', $perpindahan->alamat_tujuan) }}" required>
                                        </div>
                                    </div>




                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rt-column">RT Tujuan</label>
                                              <select name="rt_tujuan" id="rt-column" class="form-select">
                                                  <option value="" selected>-- Pilih RT --</option>
                                                    @foreach ($rt as $r)
                                                        <option value="{{ $r->no_rt }}" {{ old('rt_tujuan', $perpindahan->rt_tujuan) == $r->no_rt ? 'selected' : '' }}>
                                                            {{ $r->no_rt }}</option>
                                                    @endforeach
                                              </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rw-column">RW Tujuan</label>
                                            <input type="text" id="rw-column" name="rw_tujuan" class="form-control"
                                                placeholder="rw" value="{{ old('rw', $perpindahan->rw_tujuan) }}" required
                                                readonly>
                                            {{-- <input type="number" name="dusun_id" value="{{ $dusun->id }}" hidden> --}}

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rw-column">Alamat Asal</label>
                                            <input type="text" id="rw-column" name="alamat_asal" class="form-control"
                                                placeholder="Alamat Asal"
                                                value="{{ old('alamat_asal', $perpindahan->alamat_asal) }}" required>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rw-column">Desa asal</label>
                                            <input type="text" id="rw-column" name="desa_asal" class="form-control"
                                                placeholder="Desa Asal"
                                                value="{{ old('desa_asal', $perpindahan->desa_asal) }}" required>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rw-column">Kecamatan Asal</label>
                                            <input type="text" id="rw-column" name="kecamatan_asal"
                                                class="form-control" placeholder="Kecamatan Asal"
                                                value="{{ old('kecamatan_asal', $perpindahan->kecamatan_asal) }}"
                                                required>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rw-column">Kabupaten/Kota Asal</label>
                                            <input type="text" id="rw-column" name="kabupaten_asal"
                                                class="form-control" placeholder="Kabupaten Asal"
                                                value="{{ old('kabupaten_asal', $perpindahan->kabupaten_asal) }}"
                                                required>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rw-column">Provinsi Asal</label>
                                            <input type="text" id="rw-column" name="provinsi_asal"
                                                class="form-control" placeholder="Provinsi Asal"
                                                value="{{ old('provinsi_asal', $perpindahan->provinsi_asal) }}" required>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rw-column">Alasan</label>
                                            <input type="text" id="rw-column" name="alasan" class="form-control"
                                                placeholder="Alasan"
                                                value="{{ old('alasan', $perpindahan->alasan_perpindahan) }}" required>


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

        flatpickr("#tanggal-pelaporan", {
            dateFormat: "Y-m-d",
        });
    </script>
@endsection
