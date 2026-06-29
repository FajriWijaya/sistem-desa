@extends('layouts.main')

{{-- @dd($mutasi-) --}}

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Kelahiran RW {{ $rw->no_rw }}</h3>

            </div>
            <section class="section">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Filter</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('kelahiran.filter', $rw->no_rw) }}" method="post">
                            @csrf
                            <div class="row g-3">

                                {{-- Filter Tanggal --}}
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Tanggal Pelaporan</label>
                                    <input type="text" name="tanggal_pelaporan" class="form-control"
                                        value="{{ request()->tanggal_pelaporan }}" id="tanggal_pelaporan">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Tanggal Kelahiran</label>
                                    <input type="text" name="tanggal_kelahiran" class="form-control"
                                        value="{{ request()->tanggal_kelahiran }}" id="tanggal_kelahiran">
                                </div>


                                <div class="col-md-3">
                                    <label class="form-label fw-bold">RT</label>
                                    <select name="rw" id="" class="form-select">
                                        @foreach ($rt as $d)
                                            <option value="{{ $d->id }}">RT {{ $d->no_rt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="" class="form-select">
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>

                                {{-- Tombol Filter --}}
                                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('kelahiran', $rw->no_rw) }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                                    </a>
                                    <button class="btn btn-primary px-4" type="submit">
                                        <i class="bi bi-funnel"></i> Filter
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <section class="section">

        <div class="card">
            <div class="card-header">List Data Kelahiran</div>
            <div class="d-flex mb-3 me-4 justify-content-end gap-2">


                 <a href="{{ route('kelahiran.print', $rw->no_rw) }}" target="_blank" class="btn btn-outline-info">
                    <i class="fa-solid fa-print"></i>
                </a>

                <a href="{{ route('kelahiran.pdf', $rw->no_rw) }}" class="btn btn-outline-danger">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>

                <a href="{{ route('kelahiran.create', $rw->no_rw) }}" class="btn btn-outline-primary">
                    Catat Data Kelahiran
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
                            <th>Tanggal Pelaporan</th>
                            <th>No KK</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Nama Ayah</th>
                            <th>Nama Ibu</th>

                            <th>Alamat</th>
                            <th>RT</th>
                            <th>RW</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelahiran as $k)
                            <tr>
                                <td>{{ $k->tanggal_pelaporan }}</td>
                                <td>{{ $k->keluarga->no_kk }}</td>
                                <td>{{ $k->mutasiPenduduk->penduduk->nik }}</td>
                                <td>{{ $k->nama_lengkap }}</td>
                                <td>{{ $k->tanggal_lahir }}</td>
                                <td>{{ $k->jenis_kelamin }}</td>
                                <td>{{ $k->ayah->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $k->ibu->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $k->mutasiPenduduk->penduduk->alamat ?? 'N/A' }}</td>
                                <td>{{ $k->mutasiPenduduk->penduduk->rt->no_rt ?? 'N/A' }}</td>
                                <td>{{ $k->mutasiPenduduk->penduduk->rt->rw->no_rw ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex justify-content-end gap-1">

                                        <a href="{{ route('kelahiran.edit', $k->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form id="delete-form-{{ $k->id }}"
                                            action="{{ route('kelahiran.destroy', $k->id) }}" method="POST"
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

@section('script')
    <script>
        flatpickr("#tanggal_pelaporan", {
            dateFormat: "Y-m-d",
            mode: 'range',
        });
        flatpickr("#tanggal_kelahiran", {
            dateFormat: "Y-m-d",
            mode: 'range',
        });
    </script>
@endsection
