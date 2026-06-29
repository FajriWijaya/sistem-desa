<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dusun;
use App\Models\MutasiPenduduk;
use App\Models\Penduduk;
use App\Models\Perpindahan;
use App\Models\RT;
use App\Models\RW;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PindahKeluarController extends Controller
{
    public function index(RW $rw)
    {
        session()->flush();

        $rt = RT::where('rw_id', $rw->id)->get();
        $penduduk = MutasiPenduduk::with(['penduduk', 'perpindahan'])
            ->where('jenis_mutasi', 'pengurangan')
            ->where('keterangan', 'pindah keluar')
            ->whereHas('penduduk.rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            })
            ->latest()
            ->get();
        // dd( $penduduk);
        // dd($pnduduk);
        return view('pindah_keluar.index', compact('rw', 'penduduk', 'rt'));
    }

    public function RW()
    {
        $rw = RW::with('dusun')
            ->withCount([
                'penduduk as jumlah_penduduk' => function ($query) {
                    $query->whereHas('mutasiPenduduk', function ($q) {
                        $q->where('jenis_mutasi', 'pengurangan')
                            ->where('keterangan', 'pindah keluar');
                    });
                }
            ])
            ->get();

        return view('pindah_keluar.rw', compact('rw'));
    }


    public function filter(RW $rw, Request $request)
    {


        $query = MutasiPenduduk::with(['penduduk', 'perpindahan'])
            ->where('jenis_mutasi', 'pengurangan')
            ->where('keterangan', 'pindah keluar')
            ->whereHas('penduduk.rt', function ($q) use ($rw) {
                $q->where('rw_id', $rw->id);
            });

        // Hanya filter jika ada request (tidak wajib memiliki perpindahan)
        if ($request->filled('tanggal_pelaporan')) {
            $tanggal = explode('to', $request->tanggal_pelaporan);
            $tanggalMulai = trim($tanggal[0] ?? '');
            $tanggalSampai = trim($tanggal[1] ?? '');

            // Gunakan whereHas atau left join
            $query->whereHas('perpindahan', function ($q) use ($tanggalMulai, $tanggalSampai) {
                if ($tanggalMulai && $tanggalSampai) {
                    $q->whereBetween('tanggal_pelaporan', [$tanggalMulai, $tanggalSampai]);
                } elseif ($tanggalMulai) {
                    $q->where('tanggal_pelaporan', '>=', $tanggalMulai);
                } elseif ($tanggalSampai) {
                    $q->where('tanggal_pelaporan', '<=', $tanggalSampai);
                }
            });
        }

        if ($request->filled('klasifikasi')) {
            $query->whereHas('perpindahan', function ($q) use ($request) {
                $q->where('klasifikasi_perpindahan', $request->klasifikasi);
            });
        }

        $penduduk = $query->get();

        session([
            "klasifikasi" => $request->klasifikasi,
            'tanggal_pelaporan' => $request->tanggal_pelaporan
        ]);

        return view('pindah_keluar.index', compact('penduduk', 'rw'));
    }


    public function print(RW $rw)
    {

        $query = MutasiPenduduk::with(['penduduk', 'perpindahan'])
            ->where('jenis_mutasi', 'pengurangan')
            ->where('keterangan', 'pindah keluar')
            ->whereHas('penduduk.rt', function ($q) use ($rw) {
                $q->where('rw_id', $rw->id);
            });

        // Hanya filter jika ada request (tidak wajib memiliki perpindahan)
        if (session()->has('tanggal_pelaporan')) {
            $tanggal = explode('to', session('tanggal_pelaporan'));
            $tanggalMulai = trim($tanggal[0] ?? '');
            $tanggalSampai = trim($tanggal[1] ?? '');

            // Gunakan whereHas atau left join
            $query->whereHas('perpindahan', function ($q) use ($tanggalMulai, $tanggalSampai) {
                if ($tanggalMulai && $tanggalSampai) {
                    $q->whereBetween('tanggal_pelaporan', [$tanggalMulai, $tanggalSampai]);
                } elseif ($tanggalMulai) {
                    $q->where('tanggal_pelaporan', '>=', $tanggalMulai);
                } elseif ($tanggalSampai) {
                    $q->where('tanggal_pelaporan', '<=', $tanggalSampai);
                }
            });
        }

        if (session()->has('klasifikasi')) {
            $query->whereHas('perpindahan', function ($q) {
                $q->where('klasifikasi_perpindahan', session('klasifikasi'));
            });
        }

        $penduduk = $query->get();

        return view('pindah_keluar.print', compact('penduduk', 'rw'));
    }

    public function ExportPDF(RW $rw)
    {
        $query = MutasiPenduduk::with(['penduduk', 'perpindahan'])
            ->where('jenis_mutasi', 'pengurangan')
            ->where('keterangan', 'pindah keluar')
            ->whereHas('penduduk.rt', function ($q) use ($rw) {
                $q->where('rw_id', $rw->id);
            });

        // Hanya filter jika ada request (tidak wajib memiliki perpindahan)
        if (session()->has('tanggal_pelaporan')) {
            $tanggal = explode('to', session('tanggal_pelaporan'));
            $tanggalMulai = trim($tanggal[0] ?? '');
            $tanggalSampai = trim($tanggal[1] ?? '');

            // Gunakan whereHas atau left join
            $query->whereHas('perpindahan', function ($q) use ($tanggalMulai, $tanggalSampai) {
                if ($tanggalMulai && $tanggalSampai) {
                    $q->whereBetween('tanggal_pelaporan', [$tanggalMulai, $tanggalSampai]);
                } elseif ($tanggalMulai) {
                    $q->where('tanggal_pelaporan', '>=', $tanggalMulai);
                } elseif ($tanggalSampai) {
                    $q->where('tanggal_pelaporan', '<=', $tanggalSampai);
                }
            });
        }

        if (session()->has('klasifikasi')) {
            $query->whereHas('perpindahan', function ($q) {
                $q->where('klasifikasi_perpindahan', session('klasifikasi'));
            });
        }

        $penduduk = $query->get();

        $pdf = Pdf::loadView('pindah_keluar.pdf',  ['penduduk' => $penduduk, 'rw' => $rw])
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

        return $pdf->download('pindah_keluar.pdf');
    }

    public function edit(Perpindahan $perpindahan)
    {
        $perpindahan->load('mutasiPenduduk.penduduk');
        $penduduk = Penduduk::whereDoesntHave('mutasiPenduduk')
            ->orWhereHas('mutasiPenduduk', function ($query) {
                $query->where('keterangan', '!=', 'pindah keluar');
            })->latest()->get();
        return view('pindah_keluar.edit', compact('perpindahan', 'penduduk'));
    }

    public function update(Request $request, Perpindahan $perpindahan)
    {
        $validateData = $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'tanggal_pelaporan' => 'required|date',
            'klasifikasi' => 'required|string|max:255',
            'alamat_asal' => 'required|string|max:255',
            'rt_asal' => 'required',
            'rw_asal' => 'required',
            'alamat_tujuan' => 'required|string|max:255',
            'desa_tujuan' => 'required|string|max:255',
            'kecamatan_tujuan' => 'required|string|max:255',
            'kabupaten_tujuan' => 'required|string|max:255',
            'provinsi_tujuan' => 'required|string|max:255',
            'alasan' => 'required|string|max:255',
        ]);

        $mutasi = MutasiPenduduk::find($perpindahan->mutasi_penduduk_id);
        $mutasi->update([
            'penduduk_id' => $validateData['penduduk_id'],
            'jenis_mutasi' => 'pengurangan',
            'keterangan' => 'pindah keluar',
            'tanggal_mutasi' => $validateData['tanggal_pelaporan']
        ]);

        $penduduk = Penduduk::find($validateData['penduduk_id']);
        $penduduk->update([
            'status_kependudukan' => 'tidak aktif',
        ]);

        $perpindahan->update([
            'jenis_perpindahan' => $mutasi->keterangan,
            'alamat_tujuan' => $request->alamat_tujuan,
            'desa_tujuan' => $request->desa_tujuan,
            'kecamatan_tujuan' => $request->kecamatan_tujuan,
            'kabupaten_tujuan' => $request->kabupaten_tujuan,
            'provinsi_tujuan' => $request->provinsi_tujuan,
            'alamat_asal' => $request->alamat_asal,
            'rt_asal' => $request->rt_asal,
            'rw_asal' => $request->rw_asal,
            'klasifikasi_perpindahan' => $request->klasifikasi,
            'tanggal_pelaporan' => $request->tanggal_pelaporan,
            'alasan_perpindahan' => $request->alasan,
        ]);

        $dusun = Dusun::where('rw', $request->rw_asal)->first();

        return redirect()->route('pindah_keluar', $dusun->id)->with('updated', 'penduduk telah diupdate');
    }

    public function create(RW $rw)
    {
        $penduduk = Penduduk::with('rt')->whereDoesntHave('mutasiPenduduk')
            ->orWhereHas('mutasiPenduduk', function ($query) {
                $query->where('keterangan', '!=', 'pindah keluar');
            })->latest()->get();
        $rw->load('rt');
        $rt = RT::where('rw_id', $rw->id)->get();

        // dd($penduduk, $rw, $rt);
        return view('pindah_keluar.create', compact('penduduk', 'rw', 'rt'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'tanggal_pelaporan' => 'required|date',
            'klasifikasi' => 'required|string|max:255',
            'alamat_asal' => 'required|string|max:255',
            'rt_asal' => 'required',
            'rw_asal' => 'required',
            'dusun_id' => 'required|exists:dusun,id',
            'alamat_tujuan' => 'required|string|max:255',
            'desa_tujuan' => 'required|string|max:255',
            'kecamatan_tujuan' => 'required|string|max:255',
            'kabupaten_tujuan' => 'required|string|max:255',
            'provinsi_tujuan' => 'required|string|max:255',
            'alasan' => 'required|string|max:255',
        ]);


        $dusun = RW::where('no_rw', $request->rw_asal)->first();
        //    dd($dusun);

        $mutasi = MutasiPenduduk::create([
            'penduduk_id' => $validateData['penduduk_id'],
            'jenis_mutasi' => 'pengurangan',
            'keterangan' => 'pindah keluar',
            'tanggal_mutasi' => $validateData['tanggal_pelaporan']
        ]);

        $penduduk = Penduduk::find($validateData['penduduk_id']);
        $penduduk->update([
            'status_kependudukan' => 'tidak aktif',
        ]);

        Perpindahan::create([
            'mutasi_penduduk_id' => $mutasi->id,
            'jenis_perpindahan' => $mutasi->keterangan,
            'alamat_tujuan' => $request->alamat_tujuan,
            'desa_tujuan' => $request->desa_tujuan,
            'kecamatan_tujuan' => $request->kecamatan_tujuan,
            'kabupaten_tujuan' => $request->kabupaten_tujuan,
            'provinsi_tujuan' => $request->provinsi_tujuan,
            'alamat_asal' => $request->alamat_asal,
            'rt_asal' => $request->rt_asal,
            'rw_asal' => $request->rw_asal,
            'klasifikasi_perpindahan' => $request->klasifikasi,
            'tanggal_pelaporan' => $request->tanggal_pelaporan,
            'alasan_perpindahan' => $request->alasan,
        ]);



        return redirect()->route('pindah_keluar', $dusun->id)->with('created', 'penduduk telah diacatat');
    }
}