        @extends('layouts.main')

        @section('content')
            <div class="container-fluid py-4">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-9">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <h5 class="card-title mb-0 fw-bold">
                                    <i class="fas fa-user-circle me-2"></i>Detail Penduduk
                                </h5>
                            </div>

                            <div class="card-body p-4">
                                <div class="row g-4">

                                    <div class="col-12 col-md-6">
                                        <div class="info-group">

                                            <p class="form-control-plaintext fs-5 fw-medium">NIK: {{ $penduduk->nik }}</p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium">Nama:
                                                {{ $penduduk->nama_lengkap }}</p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium">
                                                Jenis Kelamin: {{ $penduduk->jenis_kelamin }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium">Tempat Lahir:
                                                {{ $penduduk->tempat_lahir }}</p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="info-group">

                                            <p class="form-control-plaintext fs-5 fw-medium">
                                                Tanggal Lahir:
                                                {{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('d M Y') ?? '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium">Nama Ibu:
                                                {{ $penduduk->nama_ibu }}</p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium">Nama Ayah:
                                                {{ $penduduk->nama_ayah }}</p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="info-group">

                                            <p class="form-control-plaintext fs-5 fw-medium">RT: {{ $penduduk->rt->no_rt }}</p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium">RW: {{ $penduduk->rt->rw->no_rw }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium">Dusun : 
                                                {{ $penduduk->rt->rw->dusun->nama_dusun }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium">Profesi:
                                                {{ $penduduk->profesi }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium">Agama: {{ $penduduk->agama }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium"> Pendidikan Terkahir:
                                                {{ $penduduk->pendidikan }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium"> Status Kependudukan: <span
                                                    class="badge text-bg-{{ $penduduk->status_kependudukan === 'aktif' ? 'success' : 'secondary' }}">
                                                    {{ $penduduk->status_kependudukan }}
                                                </span></p>
                                        </div>
                                    </div>

             

                                    <div class="col-12 col-md-6">
                                        <div class="info-group">
                                            <p class="form-control-plaintext fs-5 fw-medium">Alamat:
                                                {{ $penduduk->alamat }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 d-flex justify-content-between">
                                    <a href="{{ route('penduduk.index', $penduduk->rt->rw->no_rw) }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
