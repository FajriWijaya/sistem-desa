@extends('layouts.main')

{{-- @dd($penduduk) --}}

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Penduduk Masuk RW {{ $rw->no_rw }}</h3>

            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item " aria-current="page">
                            <a href="{{ route('pindah_masuk.dusun') }}">Dusun</a>
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
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Filter</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pindah_masuk.filter', $rw->no_rw) }}" method="post">
                    @csrf
                    <div class="row g-3">

                        {{-- Filter Tanggal --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Tanggal Pelaporan</label>
                            <input type="text" name="tanggal_pelaporan" class="form-control"
                                value="{{ request()->tanggal_pelaporan }}" id="tanggal_pelaporan">
                        </div>



                        {{-- Filter Kategori --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Klasifikasi</label>
                            <select name="klasifikasi" class="form-select">
                                <option value="">-- Semua Klasifikasi --</option>
                                <option value="antar desa/kelurahan dalam satu kecamatan">antar desa/kelurahan dalam satu
                                    kecamatan</option>
                                <option value="pindah dalam satu desa/kelurahan">pindah dalam satu desa/kelurahan</option>
                                <option value="antar kecamatan dalam satu kabupaten/kota">antar kecamatan dalam satu
                                    kabupaten/kota</option>
                                <option value="antar kabupaten/kota dalam satu provinsi">antar kabupaten/kota dalam satu
                                    provinsi</option>
                            </select>
                        </div>

                        {{-- Filter Dicatat Oleh --}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold">RT</label>
                            <select name="rw" id="" class="form-select">
                                @foreach ($rt as $d)
                                    <option value="{{ $d->id }}">RT {{ $d->no_rt }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tombol Filter --}}
                        <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                            <a href="" class="btn btn-secondary">
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

    <section class="section">

        <div class="card">
            <div class="card-header">Simple Datatable</div>
            <div class="d-flex mb-3 me-4 justify-content-end gap-2">
                <a href="{{ route('pindah_masuk.pdf', $rw->no_rw) }}" class="btn btn-outline-danger">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>

                <a href="{{ route('pindah_masuk.print', $rw->no_rw) }}" target="_blank" class="btn btn-outline-info">
                    <i class="fa-solid fa-print"></i>
                </a>
                <a href="{{ route('pindah_masuk.create', $rw->no_rw) }}" class="btn btn-outline-primary">
                    Catat Penduduk Masuk
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
                            <td rowspan="2">no</td>
                            <td rowspan="2">Tanggal Pelaporan</td>
                            <td rowspan="2">klafikasi</td>
                            <td rowspan="2">NIK</td>
                            <td rowspan="2">Nama Pemohon</td>
                            <td rowspan="2">Pekerjann</td>
                            <td colspan="3">tujuan</td>
                            <td colspan="5">asal</td>
                        </tr>
                        <tr>
                            <td>alamat</td>
                            <td>RT</td>
                            <td>RW</td>
                            <td>alamat</td>
                            <td>desa</td>
                            <td>kecamatan</td>
                            <td>kabupaten</td>
                            <td>propvinsi</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penduduk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->perpindahan->tanggal_pelaporan ?? '-' }}</td>
                                <td>{{ $item->perpindahan->klasifikasi_perpindahan ?? '-' }}</td>
                                <td>{{ $item->penduduk->nik ?? '-' }}</td>
                                <td>{{ $item->penduduk->nama_lengkap ?? '-' }}</td>
                                <td>{{ $item->penduduk->profesi ?? '-' }}</td>
                                <td>{{ $item->perpindahan->alamat_tujuan ?? '-' }}</td>
                                <td>{{ $item->perpindahan->rt_tujuan ?? '-' }}</td>
                                <td>{{ $item->perpindahan->rw_tujuan ?? '-' }}</td>
                                <td>{{ $item->perpindahan->alamat_asal ?? '-' }}</td>
                                <td>{{ $item->perpindahan->desa_asal ?? '-' }}</td>
                                <td>{{ $item->perpindahan->kecamatan_asal ?? '-' }}</td>
                                <td>{{ $item->perpindahan->kabupaten_asal ?? '-' }}</td>
                                <td>{{ $item->perpindahan->provinsi_asal ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('pindah_masuk.edit', $item->perpindahan->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('pindah_masuk.destroy', $item->perpindahan->id) }}"
                                            method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="window.confirmDelete({{ $item->id }})" title="Hapus">

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

@section('script')
    <script>
        flatpickr("#tanggal_pelaporan", {
            dateFormat: "Y-m-d",
            mode: 'range',
        });
    </script>
@endsection
