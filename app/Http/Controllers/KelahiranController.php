<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelahiran;
use App\Models\Keluarga;
use App\Models\MutasiPenduduk;
use App\Models\Penduduk;
use App\Models\RW;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KelahiranController extends Controller
{
    public function index(RW $rw)
    {
        session()->flush();

        $kelahiran = Kelahiran::with(['mutasiPenduduk.penduduk.rt', 'ayah', 'ibu', 'keluarga'])
            ->whereHas('mutasiPenduduk.penduduk.rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            })
            ->get();
        $rt = $rw->rt;

        // dd($kelahiran);

        return view('kelahiran.index', compact('kelahiran', 'rw', 'rt'));
    }

    public function filter(Request $request, RW $rw)
    {
        $rt = $rw->rt;

        $query = Kelahiran::with(['mutasiPenduduk.penduduk.rt', 'ayah', 'ibu', 'keluarga'])
            ->whereHas('mutasiPenduduk.penduduk.rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            });

        if ($request->filled('rt_id')) {
            $query->whereHas('mutasiPenduduk.penduduk.rt', function ($q) use ($request) {
                $q->where('id', $request->rt_id);
            });
        }
        if ($request->filled('tanggal_pelaporan')) {
            $tanggal = preg_split('/\s*to\s*/', $request->tanggal_pelaporan);

            $mulai  = $tanggal[0];
            $sampai = $tanggal[1];
            $query->whereBetween('tanggal_pelaporan', [$mulai, $sampai]);
        }

        if ($request->filled('tanggal_kelahiran')) {
            $tanggal = preg_split('/\s*to\s*/', $request->tanggal_kelahiran);

            $mulai  = $tanggal[0] ?? null;
            $sampai = $tanggal[1] ?? null;
            $query->whereBetween('tanggal_kelahiran', [$mulai, $sampai]);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $kelahiran = $query->get();

        session([
            'tanggal_pelaporan' => $request->tanggal_pelaporan,
            'tanggal_kelahiran' => $request->tanggal_kelahiran,
            'jenis_kelamin' => $request->jenis_kelamin
        ]);
        // dd($kelahiran->toArray());
        return view('kelahiran.index', compact('kelahiran', 'rw', 'rt'));
    }

    public function RW()
    {
        $rw = RW::withCount([
            'penduduk as jumlah_kelahiran' => function ($query) {
                $query->whereHas('mutasiPenduduk', function ($quary) {
                    $quary->where('jenis_mutasi', 'penambahan')
                        ->where('keterangan', 'kelahiran');
                });
            }
        ])->get();

        return view('kelahiran.rw', compact('rw'));
    }



    public function create(RW $rw)
    {
        $ayah = Penduduk::where('jenis_kelamin', 'laki-laki')
            ->where('status_kependudukan', 'aktif')
            ->where('status_perkawinan', 'Menikah')
            ->whereHas('rt', fn($q) => $q->where('rw_id', $rw->id))
            ->get();

        $ibu = Penduduk::where('jenis_kelamin', 'perempuan')
            ->where('status_kependudukan', 'aktif')
            ->where('status_perkawinan', 'Menikah')
            ->whereHas('rt', fn($q) => $q->where('rw_id', $rw->id))
            ->get();

        $kk = Keluarga::whereHas('rt', function ($query) use ($rw) {
            $query->where('rw_id', $rw->id);
        })->get();

        // dd($ayah, $ibu);

        return view('kelahiran.create', compact('rw', 'ayah', 'ibu', 'kk'));
    }


    public function print(RW $rw, Request $request)
    {
        // dd(session('jenis_kelamin'));

        $query = Kelahiran::with(['mutasiPenduduk.penduduk.rt', 'ayah', 'ibu', 'keluarga'])
            ->whereHas('mutasiPenduduk.penduduk.rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            });

        if (session()->has('rt_id')) {
            $query->whereHas('mutasiPenduduk.penduduk.rt', function ($q) use ($request) {
                $q->where('id', session('rt_id'));
            });
        }

        if (session()->has('tanggal_pelaporan')) {
            $tanggal = preg_split('/\s*to\s*/', session('tanggal_pelaporan'));

            $mulai  = $tanggal[0];
            $sampai = $tanggal[1];
            $query->whereBetween('tanggal_pelaporan', [$mulai, $sampai]);
        }

        if (session()->has('tanggal_kelahiran')) {
            $tanggal = preg_split('/\s*to\s*/', session('tanggal_kelahiran'));

            $mulai  = $tanggal[0] ?? null;
            $sampai = $tanggal[1] ?? null;
            $query->whereBetween('tanggal_kelahiran', [$mulai, $sampai]);
        }



        if (session()->has('jenis_kelamin')) {
            $query->where('jenis_kelamin', session('jenis_kelamin'));
        }

        $kelahiran = $query->get();


        // dd(session('jenis_kelamin'),$kelahiran->toArray());
        return view('kelahiran.print', compact('kelahiran', 'rw'));
    }

    public function ExportPDF(RW $rw, Request $request)
    {
        $query = Kelahiran::with(['mutasiPenduduk.penduduk.rt', 'ayah', 'ibu', 'keluarga'])
            ->whereHas('mutasiPenduduk.penduduk.rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            });



        if (session()->has('tanggal_pelaporan')) {
            $query->whereDate('tanggal_pelaporan', session('tanggal_pelaporan'));
        }

        if (session()->has('tanggal_kelahiran')) {
            $query->whereDate('tanggal_lahir', session('tanggal_kelahiran'));
        }

        if (session()->has('jenis_kelamin')) {
            $query->where('jenis_kelamin', session('jenis_kelamin'));
        }

        if (session()->has('rt_id')) {
            $query->whereHas('mutasiPenduduk.penduduk.rt', function ($q) use ($request) {
                $q->where('id', session('rt_id'));
            });
        }


        $kelahiran = $query->get();
        $pdf = Pdf::loadView('kelahiran.pdf',  ['kelahiran' => $kelahiran, 'rw' => $rw])
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'isPhpEnabled' => false,
                'margin_left' => 5,      // margin kiri (mm)
                'margin_right' => 5,     // margin kanan (mm)
                'margin_top' => 10,      // margin atas (mm)
                'margin_bottom' => 10,
            ]);

        return $pdf->download('kelahiran.pdf');
    }

    public function store(Request $request, RW $rw)
    {
        $request->validate([
            'nik' => 'required|string|unique:penduduk,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tanggal_pelaporan' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'ayah_id' => 'required|exists:penduduk,id',
            'ibu_id' => 'required|exists:penduduk,id',
            'keluarga_id' => 'required|exists:keluarga,id',
            'tempat_lahir' => 'required|string|max:255',
            'waktu_lahir' => 'required',
        ]);

        $penduduk = Penduduk::create([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'nama_ibu' => Penduduk::find($request->ibu_id)->nama_lengkap,
            'nama_ayah' => Penduduk::find($request->ayah_id)->nama_lengkap,
            'rt_id' => Keluarga::find($request->keluarga_id)->rt_id,
            'alamat' => Keluarga::find($request->keluarga_id)->alamat,
            'agama' => '-',
            'profesi' => '-',
            'pendidikan' => '-',
            'status_kependudukan' => 'aktif',
            'status_perkawinan' => 'Belum Menikah',
            'golongan_darah' => '-',
            'kewarganegaraan' => 'WNI',
        ]);

        $mutasiPenduduk = MutasiPenduduk::create([
            'penduduk_id' => $penduduk->id,
            'jenis_mutasi' => 'penambahan',
            'keterangan' => 'kelahiran',
        ]);

        $kelahiran = Kelahiran::create([
            'mutasi_penduduk_id' => $mutasiPenduduk->id,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_pelaporan' => $request->tanggal_pelaporan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'waktu_lahir' => $request->waktu_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'ayah_id' => $request->ayah_id,
            'ibu_id' => $request->ibu_id,
            'keluarga_id' => $request->keluarga_id,
        ]);

        return redirect()->route('kelahiran', $rw->no_rw)->with('created', 'Data kelahiran berhasil ditambahkan.');
    }

    public function edit(Kelahiran $kelahiran)
    {
        $kelahiran->load('mutasiPenduduk.penduduk.rt.rw');
        $rw = $kelahiran->mutasiPenduduk->penduduk->rt->rw;
        $ayah = Penduduk::where('jenis_kelamin', 'laki-laki')
            ->where('status_kependudukan', 'aktif')
            ->where('status_perkawinan', 'Menikah')
            ->whereHas('rt', fn($q) => $q->where('rw_id', $rw->id))
            ->get();

        $ibu = Penduduk::where('jenis_kelamin', 'perempuan')
            ->where('status_kependudukan', 'aktif')
            ->where('status_perkawinan', 'Menikah')
            ->whereHas('rt', fn($q) => $q->where('rw_id', $rw->id))
            ->get();

        $kk = Keluarga::whereHas('rt', function ($query) use ($rw) {
            $query->where('rw_id', $rw->id);
        })->get();

        return view('kelahiran.edit', compact('kelahiran', 'ayah', 'ibu', 'kk', 'rw'));
    }

    public function update(Request $request, Kelahiran $kelahiran)
    {
        $request->validate([
            'nik' => 'required|string|unique:penduduk,nik,' . $kelahiran->mutasiPenduduk->penduduk_id,
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tanggal_pelaporan' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'ayah_id' => 'required|exists:penduduk,id',
            'ibu_id' => 'required|exists:penduduk,id',
            'keluarga_id' => 'required|exists:keluarga,id',
            'tempat_lahir' => 'required|string|max:255',
            'waktu_lahir' => 'required',
        ]);

        $penduduk = $kelahiran->mutasiPenduduk->penduduk;
        $penduduk->update([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'nama_ibu' => Penduduk::find($request->ibu_id)->nama_lengkap,
            'nama_ayah' => Penduduk::find($request->ayah_id)->nama_lengkap,
            'rt_id' => Keluarga::find($request->keluarga_id)->rt_id,
            'alamat' => Keluarga::find($request->keluarga_id)->alamat,
        ]);

        $kelahiran->update([
            'nama_lengkap' => $request->nama_lengkap,
            'tanggal_pelaporan' => $request->tanggal_pelaporan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'waktu_lahir' => $request->waktu_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'ayah_id' => $request->ayah_id,
            'ibu_id' => $request->ibu_id,
            'keluarga_id' => $request->keluarga_id,
        ]);
        return redirect()->route('kelahiran', $kelahiran->mutasiPenduduk->penduduk->rt->rw->no_rw)->with('updated', 'Data kelahiran berhasil diupdate.');
    }

    public function destroy(Kelahiran $kelahiran)
    {
        $kelahiran->mutasiPenduduk->penduduk->delete();
        return redirect()->route('kelahiran', $kelahiran->mutasiPenduduk->penduduk->rt->rw->no_rw)->with('deleted', 'Data kelahiran berhasil dihapus.');
    }
}