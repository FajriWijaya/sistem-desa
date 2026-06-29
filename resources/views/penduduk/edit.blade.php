@extends('layouts.main')
{{-- @dd($penduduk->mutasiPenduduk->first()->kelahiran->ayah_id ) --}}
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Penduduk RW {{ $penduduk->rt->rw->no_rw }}</h3>

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
                            <form class="form" action="{{ route('penduduk.update', $penduduk->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">NIK</label>
                                            <input type="NUMBER" id="first-name-column" class="form-control"
                                                placeholder="NIK" name="nik" value="{{ old('nik', $penduduk->nik) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Nama Lengkap</label>
                                            <input type="text" id="last-name-column" class="form-control"
                                                placeholder="Nama Lengkap" name="nama_lengkap"
                                                value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="mutasi">Keterangan Mutasi</label>
                                            <select name="mutasi" id="mutasi" class="form-control">
                                                <option value="" selected>Tidak ada Catatan Mutasi</option>
                                                <option value="pindah_masuk"
                                                    {{ old('mutasi',  $penduduk->mutasiPenduduk->first()?->keterangan ) == 'pindah masuk' ? 'selected' : '' }}>
                                                    Pindah Masuk
                                                </option>
                                                <option value="kelahiran"
                                                    {{ old('mutasi', $penduduk->mutasiPenduduk->first()?->keterangan ) == 'kelahiran' ? 'selected' : '' }}>
                                                    Kelahiran</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <select class="form-select" id="basicSelect" name="jenis_kelamin">
                                                <option value="">Jenis Kelamin</option>
                                                <option value="Laki-laki"
                                                    {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>
                                                    Laki-laki
                                                </option>
                                                <option value="Perempuan"
                                                    {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>
                                                    Perempuan
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="country-floating">Alamat</label>
                                            <input type="text" id="country-floating" class="form-control" name="alamat"
                                                placeholder="Alamat" value="{{ old('alamat', $penduduk->alamat) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="text" id="tanggal_lahir" class="form-control"
                                                name="tanggal_lahir" placeholder="Tanggal Lahir"
                                                value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Tempat Lahir</label>
                                            <input type="text" id="email-id-column" class="form-control"
                                                name="tempat_lahir" placeholder="Tempat Lahir"
                                                value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="nama-ibu-column">Nama Ibu</label>
                                            <input type="text" id="nama-ibu-column" name="nama_ibu" class="form-control"
                                                placeholder="Nama Ibu" value="{{ old('nama_ibu', $penduduk->nama_ibu) }}"
                                                required>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="nama-ayah-column">Nama Ayah</label>
                                            <input type="text" id="nama-ayah-column" name="nama_ayah"
                                                class="form-control" placeholder="Nama Ayah"
                                                value="{{ old('nama_ayah', $penduduk->nama_ayah) }}" required>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rt-column">RT</label>
                                            <select name="rt_id" id="rt-column" class="form-select">
                                                <option value="" selected>-- Pilih RT --</option>
                                                @foreach ($penduduk->rt->rw->rt as $r)
                                                    <option value="{{ $r->id }}"
                                                        {{ old('rt_id', $penduduk->rt_id) == $r->id ? 'selected' : '' }}>
                                                        {{ $r->no_rt }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="rw-column">rw</label>
                                            <input type="text" id="rw-column" name="rw" class="form-control"
                                                placeholder="rw" value="{{ old('rw', $penduduk->rt->rw->no_rw) }}"
                                                readonly>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="agama-column">Agama</label>
                                            <select name="agama" id="agama-column" class="form-control" required>
                                                <option value="">Pilih Agama</option>
                                                <option value="Islam"
                                                    {{ old('agama', $penduduk->agama) == 'Islam' ? 'selected' : '' }}>
                                                    Islam</option>
                                                <option value="Kristen"
                                                    {{ old('agama', $penduduk->agama) == 'Kristen' ? 'selected' : '' }}>
                                                    Kristen</option>
                                                <option value="Katolik"
                                                    {{ old('agama', $penduduk->agama) == 'Katolik' ? 'selected' : '' }}>
                                                    Katolik</option>
                                                <option value="Hindu"
                                                    {{ old('agama', $penduduk->agama) == 'Hindu' ? 'selected' : '' }}>
                                                    Hindu</option>
                                                <option value="Buddha"
                                                    {{ old('agama', $penduduk->agama) == 'Buddha' ? 'selected' : '' }}>
                                                    Buddha</option>
                                            </select>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="profesi-column">Profesi</label>
                                            <input type="text" name="profesi" id="profesi-column"
                                                class="form-control" placeholder="Profesi"
                                                value="{{ old('profesi', $penduduk->profesi) }}" required>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="pendidikan-column">Pendidikan Terakhir</label>
                                            <select name="pendidikan" id="pendidikan-column" class="form-control"
                                                required>
                                                <option value="">Pilih Pendidikan</option>
                                                <option value="Tidak Sekolah"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'Tidak Sekolah' ? 'selected' : '' }}>
                                                    Tidak
                                                    Sekolah</option>
                                                <option value="SD"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'SD' ? 'selected' : '' }}>
                                                    SD</option>
                                                <option value="SMP"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'SMP' ? 'selected' : '' }}>
                                                    SMP</option>
                                                <option value="SMA"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'SMA' ? 'selected' : '' }}>
                                                    SMA</option>
                                                <option value="D1"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'D1' ? 'selected' : '' }}>
                                                    D1</option>
                                                <option value="D2"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'D2' ? 'selected' : '' }}>
                                                    D2</option>
                                                <option value="D3"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'D3' ? 'selected' : '' }}>
                                                    D3</option>
                                                <option value="D4"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'D4' ? 'selected' : '' }}>
                                                    D4</option>
                                                <option value="S1"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'S1' ? 'selected' : '' }}>
                                                    S1</option>
                                                <option value="S2"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'S2' ? 'selected' : '' }}>
                                                    S2</option>
                                                <option value="S3"
                                                    {{ old('pendidikan', $penduduk->pendidikan) == 'S3' ? 'selected' : '' }}>
                                                    S3</option>
                                            </select>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="pendidikan-column">Status Perkawinan</label>
                                            <select name="status_perkawinan" id="status_perkawinan-column"
                                                class="form-control" required>
                                                <option value="">Pilih Status Perkawinan</option>
                                                <option value="Belum Menikah"
                                                    {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Belum Menikah' ? 'selected' : '' }}>
                                                    Belum Menikah</option>
                                                <option value="Menikah"
                                                    {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Menikah' ? 'selected' : '' }}>
                                                    Menikah
                                                </option>
                                                <option value="Cerai Mati"
                                                    {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>
                                                    Cerai
                                                    Mati</option>
                                                <option value="Cerai Hidup"
                                                    {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>
                                                    Cerai
                                                    Hidup</option>
                                            </select>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="pendidikan-column">Golongan Darah</label>
                                            <select name="golongan_darah" id="golongan_darah-column" class="form-control"
                                                required>
                                                <option value="">Pilih Golongan Darah</option>
                                                <option value="A"
                                                    {{ old('golongan_darah', $penduduk->golongan_darah) == 'A' ? 'selected' : '' }}>
                                                    A</option>
                                                <option value="B"
                                                    {{ old('golongan_darah', $penduduk->golongan_darah) == 'B' ? 'selected' : '' }}>
                                                    B</option>
                                                <option value="AB"
                                                    {{ old('golongan_darah', $penduduk->golongan_darah) == 'AB' ? 'selected' : '' }}>
                                                    AB</option>
                                                <option value="O"
                                                    {{ old('golongan_darah', $penduduk->golongan_darah) == 'O' ? 'selected' : '' }}>
                                                    O</option>
                                            </select>


                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class='form-group'>

                                            <label for="pendidikan-column">Kewarganegaraan</label>
                                            <select name="kewarganegaraan" id="kewarganegaraan-column"
                                                class="form-control" required>
                                                <option value="">Pilih Kewarganegaraan</option>
                                                <option value="WNI"
                                                    {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>
                                                    WNI</option>
                                                <option value="WNA"
                                                    {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>
                                                    WNA</option>
                                            </select>


                                        </div>
                                    </div>

                                    @if ($penduduk->mutasiPenduduk->first()?->keterangan == 'pindah masuk')

                                    @php
                                       $pindah = $penduduk->mutasiPenduduk->first()->perpindahan ?? '';
                                       $lahir = $penduduk->mutasiPenduduk->first()->kelahiran;
                                    @endphp
                                        <div id="form-pindah"  >
                                            <h5>Data Pindah Masuk</h5>

                                            <input type="text" name="alamat_asal" placeholder="Alamat Asal"
                                                class="form-control mb-2" value="{{ $pindah->alamat_asal }}">
                                            <input type="text" name="desa_asal" placeholder="Desa Asal"
                                                class="form-control mb-2" value="{{ $pindah->desa_asal }}">
                                            <input type="text" name="kecamatan_asal" placeholder="Kecamatan Asal"
                                                class="form-control mb-2" value="{{ $pindah->kecamatan_asal }}">
                                            <input type="text" name="kabupaten_asal" placeholder="Kabupaten Asal"
                                                class="form-control mb-2" value="{{ $pindah->kecamatan_asal }}">
                                            <input type="text" name="provinsi_asal" placeholder="Provinsi Asal"
                                                class="form-control mb-2" value="{{ $pindah->provinsi_asal }}">


                                            <select name="klasifikasi_perpindahan" class="form-select" required>
                                                <option  selected>-- Klasifikasi --</option>
                                                <option value="antar desa/kelurahan dalam satu kecamatan" {{ old('klasifikasi_perpindahan', $pindah->klasifikasi_perpindahan) == 'antar desa/kelurahan dalam satu kecamatan' ? 'selected' : '' }}>antar
                                                    desa/kelurahan dalam satu kecamatan</option>
                                                <option value="pindah dalam satu desa/kelurahan" {{ old('klasifikasi_perpindahan', $pindah->klasifikasi_perpindahan) == 'pindah dalam satu desa/kelurahan' ? 'selected' : '' }}>pindah dalam satu
                                                    desa/kelurahan</option>
                                                <option value="antar kecamatan dalam satu kabupaten/kota" {{ old('klasifikasi_perpindahan', $pindah->klasifikasi_perpindahan) == 'antar kecamatan dalam satu kabupaten/kota' ? 'selected' : '' }}>antar kecamatan
                                                    dalam satu kabupaten/kota</option>
                                                <option value="antar kabupaten/kota dalam satu provinsi" {{ old('klasifikasi_perpindahan', $pindah->klasifikasi_perpindahan) == 'antar kabupaten/kota dalam satu provinsi' ? 'selected' : '' }}>antar
                                                    kabupaten/kota dalam satu provinsi</option>
                                            </select>
                                            <input type="text" name="alasan_perpindahan"
                                                placeholder="Alasan Perpindahan" class="form-control mb-2" value="{{ old('alasan_perpindahan', $pindah->alasan_perpindahan) }}">
                                            <input type="text" id="tanggal_pelaporan" name="tanggal_pelaporan"
                                                class="form-control mb-2" placeholder="Tanggal Pelaporan" value="{{ $pindah->tanggal_pelaporan }}">
                                        </div>
                                    @elseif ($penduduk->mutasiPenduduk->first()->keterangan == 'kelahiran')
                                        <div id="form-lahir"  none; margin-top:20px;">
                                            <h5>Data Kelahiran</h5>

                                            <select name="ayah_id" class="form-control mb-2">
                                                <option value="">Pilih Ayah</option>
                                                @foreach ($pendudukPria as $ayah)
                                                    <option value="{{ $ayah->id }}"
                                                        {{ old('ayah_id', $penduduk->mutasiPenduduk->first()->kelahiran->ayah_id) == $ayah->id ? 'selected' : '' }}>
                                                        {{ $ayah->nik }} - {{ $ayah->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <select name="ibu_id" class="form-control mb-2">
                                                <option value="">Pilih Ibu</option>
                                                @foreach ($pendudukWanita as $ibu)
                                                    <option value="{{ $ibu->id }}"
                                                        {{ old('ibu_id', $penduduk->mutasiPenduduk->first()->kelahiran->ibu_id) == $ibu->id ? 'selected' : '' }}>
                                                        {{ $ibu->nik }} - {{ $ibu->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>



                                            <input type="time" name="waktu_lahir" id="waktu_lahir"
                                                class="form-control mb-2" placeholder="Waktu Lahir">
                                        </div>
                                    @endif



                                    <br>
                                </div>
                                <div class="col-12 d-flex justify-content-end mb-2 me-2">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
        flatpickr("#waktu_lahir", {
            enableTime: true,
            time_24hr: true,
            noCalendar: true,
            dateFormat: "H:i",
        });


        // document.addEventListener("DOMContentLoaded", function() {
        //     const mutasi = document.getElementById("mutasi");
        //     const formPindah = document.getElementById("form-pindah");
        //     const formLahir = document.getElementById("form-lahir");

        //     function toggleForm() {
        //         const value = mutasi.value;

        //         formPindah.style.display = "none";
        //         formLahir.style.display = "none";

        //         if (value === "pindah_masuk") {
        //             formPindah.style.display = "block";
        //         } else if (value === "kelahiran") {
        //             formLahir.style.display = "block";
        //         }
        //     }

        //     mutasi.addEventListener("change", toggleForm);

        //     // biar old() tetap jalan saat validation error
        //     toggleForm();
        // });
    </script>
@endsection
