<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Kematian;
use App\Models\MutasiPenduduk;
use App\Models\Penduduk;
use App\Models\RW;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KematianController extends Controller
{
    public function index(RW $rw)
    {
        $kematian = Kematian::with(['mutasiPenduduk', 'mutasiPenduduk.penduduk', 'mutasiPenduduk.penduduk.rt.rw', 'mutasiPenduduk.penduduk.keluarga'])
            ->whereHas('mutasiPenduduk.penduduk.rt', function ($q) use ($rw) {
                $q->where('rw_id', $rw->id);
            })->latest()->get();
        $rt = $rw->rt;
        return view('kematian.index', compact('kematian', 'rw', 'rt'));
    }

    public function filter(Request $request, RW $rw)
    {
        $rt = $rw->rt;

        // dd($request->all());

        $query = Kematian::with(['mutasiPenduduk', 'mutasiPenduduk.penduduk', 'mutasiPenduduk.penduduk.rt', 'mutasiPenduduk.penduduk.rt.rw'])
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

        if ($request->filled('tanggal_kematian')) {
            $tanggal = preg_split('/\s*to\s*/', $request->tanggal_kematian);

            $mulai  = $tanggal[0] ?? null;
            $sampai = $tanggal[1] ?? null;
            $query->whereBetween('tanggal_kematian', [$mulai, $sampai]);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $kematian = $query->get();

        session([
            'tanggal_pelaporan' => $request->tanggal_pelaporan,
            'tanggal_kematian' => $request->tanggal_kematian,
            'rw_id' => $rw->id
        ]);

        return view('kematian.index', compact('kematian', 'rw', 'rt'));
    }

    public function print(RW $rw)
    {
        $query = Kematian::with(['mutasiPenduduk', 'mutasiPenduduk.penduduk', 'mutasiPenduduk.penduduk.keluarga', 'mutasiPenduduk.penduduk.rt', 'mutasiPenduduk.penduduk.rt.rw'])
            ->whereHas('mutasiPenduduk.penduduk.rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            });

        if (session()->has('rt_id')) {
            $query->whereHas('mutasiPenduduk.penduduk.rt', function ($q) {
                $q->where('id', session('rt_id'));
            });
        }

        if (session()->has('tanggal_pelaporan')) {
            $tanggal = preg_split('/\s*to\s*/', session('tanggal_pelaporan'));

            $mulai  = $tanggal[0];
            $sampai = $tanggal[1];
            $query->whereBetween('tanggal_pelaporan', [$mulai, $sampai]);
        }

        if (session()->has('tanggal_kematian')) {
            $tanggal = preg_split('/\s*to\s*/', session('tanggal_kemtian'));

            $mulai  = $tanggal[0] ?? null;
            $sampai = $tanggal[1] ?? null;
            $query->whereBetween('tanggal_kematian', [$mulai, $sampai]);
        }

        if (session()->has('jenis_kelamin')) {
            $query->where('jenis_kelamin', session('jenis_kelamin'));
        }

        $data = $query->get();
        // dd($data);

        return view('kematian.print', compact('data'));
    }

    public function ExportPDF(RW $rw)
    {
        $query = Kematian::with(['mutasiPenduduk', 'mutasiPenduduk.penduduk', 'mutasiPenduduk.penduduk.keluarga', 'mutasiPenduduk.penduduk.rt', 'mutasiPenduduk.penduduk.rt.rw'])
            ->whereHas('mutasiPenduduk.penduduk.rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            });

        if (session()->has('rt_id')) {
            $query->whereHas('mutasiPenduduk.penduduk.rt', function ($q) {
                $q->where('id', session('rt_id'));
            });
        }

        if (session()->has('tanggal_pelaporan')) {
            $tanggal = preg_split('/\s*to\s*/', session('tanggal_pelaporan'));

            $mulai  = $tanggal[0];
            $sampai = $tanggal[1];
            $query->whereBetween('tanggal_pelaporan', [$mulai, $sampai]);
        }

        if (session()->has('tanggal_kematian')) {
            $tanggal = preg_split('/\s*to\s*/', session('tanggal_kemtian'));

            $mulai  = $tanggal[0] ?? null;
            $sampai = $tanggal[1] ?? null;
            $query->whereBetween('tanggal_kematian', [$mulai, $sampai]);
        }

        if (session()->has('jenis_kelamin')) {
            $query->where('jenis_kelamin', session('jenis_kelamin'));
        }

        $data = $query->get();

                $pdf = Pdf::loadView('kematian.pdf',  ['data' => $data, 'rw' => $rw])
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

        return $pdf->download('kematian.pdf');
    }

    public function RW()
    {
        $rw = RW::withCount([
            'penduduk as jumlah_kematian' => function ($query) {
                $query->whereHas('mutasiPenduduk', function ($q) {
                    $q->where('jenis_mutasi', 'pengurangan')
                        ->where('keterangan', 'meninggal');
                });
            }
        ])->get();

        // dd($rw);
        return view('kematian.rw', compact('rw'));
    }



    public function create(RW $rw)
    {
        $penduduk = Penduduk::with(['rt.rw', 'mutasiPenduduk.kematian'])
            ->whereDoesntHave('mutasiPenduduk')
            ->orWhereHas('mutasiPenduduk', function ($query) {
                $query->where('keterangan', '!=', 'meninggal');
            })
            ->where('status_kependudukan', 'aktif')
            ->whereHas('rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            })
            ->get();

        $keluarga = Keluarga::with('rt.rw')
            ->whereHas('rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            })
            ->get();


        return view('kematian.create', compact('rw', 'penduduk', 'keluarga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'no_kk' => 'required|exists:keluarga,no_kk',
            'tanggal_kematian' => 'required|date',
            'tanggal_pelaporan' => 'required|date',
            'waktu_kematian' => 'required',
        ]);

        $mutasi = MutasiPenduduk::create([
            'penduduk_id' => $request->penduduk_id,
            'jenis_mutasi' => 'pengurangan',
            'keterangan' => 'meninggal',
            'tanggal_mutasi' => $request->tanggal_pelaporan,
        ]);

        $penduduk = Penduduk::find($request->penduduk_id);

        $kematian = Kematian::create([
            'mutasi_penduduk_id' => $mutasi->id,
            'tanggal_kematian' => $request->tanggal_kematian,
            'tanggal_pelaporan' => $request->tanggal_pelaporan,
            'waktu_kematian' => $request->waktu_kematian,
        ]);

        $penduduk->update([
            'status_kependudukan' => 'tidak aktif',
        ]);

        return redirect()->route('kematian', $penduduk->rt->rw->no_rw)->with('created', 'Data kematian berhasil disimpan.');
    }

    public function edit(Kematian $kematian)
    {
        $kematian->load(['mutasiPenduduk.penduduk.rt.rw']);
        $rw = $kematian->mutasiPenduduk->penduduk->rt->rw;
        return view('kematian.edit', compact('kematian', 'rw'));
    }

    public function update(Kematian $kematian, Request $request)
    {
        $validateDate = $request->validate([
            'tanggal_kematian' => 'required|date',
            'tanggal_pelaporan' => 'required|date',
            'waktu_kematian' => 'required',
        ]);

        $kematian->update($validateDate);
        return redirect()->route('kematian', $kematian->mutasiPenduduk->penduduk->rt->rw->no_rw)->with('updated', 'Data kematian berhasil disimpan.');
    }

    public function destroy(Kematian $kematian)
    {
        $kematian->delete();
        return redirect()->route('kematian', $kematian->mutasiPenduduk->penduduk->rt->rw->no_rw)->with('deleted', 'Data kematian berhasil disimpan.');
    }
}