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
use Carbon\Carbon;
use Illuminate\Http\Request;

use function Symfony\Component\Clock\now;

class PindahMasukController extends Controller
{
    public function index(RW $rw)
    {
        session()->flush();
        $rt = RT::where('rw_id', $rw->id)->get();
        $penduduk = MutasiPenduduk::with(['penduduk', 'perpindahan'])
            ->where('jenis_mutasi', 'penambahan')
            ->where('keterangan', 'pindah masuk')
            ->whereHas('penduduk.rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            })
            ->latest()
            ->get();
        // dd( $penduduk);
        // dd($pnduduk);
        return view('pindah_masuk.index', compact('rw', 'penduduk', 'rt'));
    }


    public function filter(RW $rw, Request $request)
    {
        $rt = RT::where('rw_id', $rw->id)->get();

        $query = MutasiPenduduk::with(['penduduk', 'perpindahan'])
            ->where('jenis_mutasi', 'penambahan')
            ->where('keterangan', 'pindah masuk')
            ->whereHas('penduduk.rt', function ($q) use ($rw) {
                $q->where('rw_id', $rw->id);
            });

        // =========================
        // FILTER TANGGAL (RANGE)
        // =========================
        if ($request->filled('tanggal_pelaporan')) {

            $tanggal = preg_split('/\s*to\s*/', $request->tanggal_pelaporan);

            $mulai  = $tanggal[0] ?? null;
            $sampai = $tanggal[1] ?? null;

            $query->whereHas('perpindahan', function ($q) use ($mulai, $sampai) {
                if ($mulai && $sampai) {
                    $q->whereBetween('tanggal_pelaporan', [$mulai, $sampai]);
                } elseif ($mulai) {
                    $q->whereDate('tanggal_pelaporan', '>=', $mulai);
                } elseif ($sampai) {
                    $q->whereDate('tanggal_pelaporan', '<=', $sampai);
                }
            });
        }

        // =========================
        // FILTER KLASIFIKASI
        // =========================
        if ($request->filled('klasifikasi')) {
            $query->whereHas('perpindahan', function ($q) use ($request) {
                $q->where('klasifikasi_perpindahan', $request->klasifikasi);
            });
        }

        // =========================
        // FILTER RT
        // =========================
        if ($request->filled('rt')) {
            $query->whereHas('perpindahan', function ($q) use ($request) {
                $q->where('rt_id', $request->rt);
            });
        }

        $penduduk = $query->latest()->get();

        // =========================
        // SIMPAN SESSION
        // =========================
        session([
            'klasifikasi' => $request->klasifikasi,
            'tanggal_pelaporan' => $request->tanggal_pelaporan
        ]);

        return view('pindah_masuk.index', compact('penduduk', 'rw', 'rt'));
    }


    public function print(RW $rw, Request $request)
    {

        $query = MutasiPenduduk::with(['penduduk', 'perpindahan'])
            ->where('jenis_mutasi', 'penambahan')
            ->where('keterangan', 'pindah masuk')
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

       
        return view('pindah_masuk.print', compact('penduduk', 'rw'));
    }

    public function ExportPDF(RW $rw)
    {
       $query = MutasiPenduduk::with(['penduduk', 'perpindahan'])
        ->where('jenis_mutasi', 'penambahan')
        ->where('keterangan', 'pindah masuk')
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

        
        $pdf = Pdf::loadView('pindah_masuk.pdf',  ['penduduk' => $penduduk, 'rw' => $rw])
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

        return $pdf->download('pindah_masuk.pdf');
    }

    public function RW()
    {
        $rw = RW::with('dusun')
            ->withCount([
                'penduduk as jumlah_penduduk' => function ($query) {
                    $query->whereHas('mutasiPenduduk', function ($q) {
                        $q->where('jenis_mutasi', 'penambahan')
                            ->where('keterangan', 'pindah masuk');
                    });
                }
            ])
            ->get();

        return view('pindah_masuk.rw', compact('rw'));
    }

    public function create(RW $rw)
    {
        $penduduk = Penduduk::whereDoesntHave('mutasiPenduduk')
            ->orWhereHas('mutasiPenduduk', function ($query) {
                $query->where('keterangan', '!=', 'pindah masuk');
            })->latest()->get();
        $rw->load('rt');
        $rt = $rw->rt;
        return view('pindah_masuk.craate', compact('penduduk', 'rw', 'rt'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'tanggal_pelaporan' => 'required|date',
            'klasifikasi' => 'required|string|max:255',
            'alamat_tujuan' => 'required|string|max:255',
            'rt_tujuan' => 'required',
            'rw_tujuan' => "required",
            'alamat_asal' => 'required|string|max:255',
            'desa_asal' => 'required|string|max:255',
            'kecamatan_asal' => 'required|string|max:255',
            'kabupaten_asal' => 'required|string|max:255',
            'provinsi_asal' => 'required|string|max:255',
            'alasan' => 'required|string|max:255',
        ]);


        //    dd($dusun);

        $mutasi = MutasiPenduduk::create([
            'penduduk_id' => $validateData['penduduk_id'],
            'jenis_mutasi' => 'penambahan',
            'keterangan' => 'pindah masuk',
            'tanggal_mutasi' => $validateData['tanggal_pelaporan']
        ]);

        $penduduk = Penduduk::find($validateData['penduduk_id']);

        Perpindahan::create([
            'mutasi_penduduk_id' => $mutasi->id,
            'jenis_perpndahan' => $mutasi->keterangan,
            'alamat_asal' => $request->alamat_asal,
            'desa_asal' => $request->desa_asal,
            'kecamatan_asal' => $request->kecamatan_asal,
            'kabupaten_asal' => $request->kabupaten_asal,
            'provinsi_asal' => $request->provinsi_asal,
            'alamat_tujuan' => $request->alamat_tujuan,
            'rt_tujuan' => $request->rt_tujuan,
            'rw_tujuan' => $request->rw_tujuan,
            'klasifikasi_perpindahan' => $request->klasifikasi,
            'tanggal_pelaporan' => $request->tanggal_pelaporan,
            'alasan_perpindahan' => $request->alasan,
        ]);

        return redirect()->route('pindah_masuk', $penduduk->rt->rw->no_rw)->with('created', 'penduduk telah diacatat');
    }

    public function edit(Perpindahan $perpindahan)
    {
        $perpindahan->load('mutasiPenduduk', 'mutasiPenduduk.penduduk', 'mutasiPenduduk.penduduk.rt', 'mutasiPenduduk.penduduk.rt.rw');
        $perpindahan->load('mutasiPenduduk.penduduk');
        // $penduduk = Penduduk::whereDoesntHave('mutasiPenduduk')
        //     ->orWhereHas('mutasiPenduduk', function ($query) {
        //         $query->where('keterangan', '!=', 'pindah masuk');
        //     })->latest()->get();
        
        $rt = RT::where('rw_id', $perpindahan->mutasiPenduduk->penduduk->rt->rw->id)->get();
        return view('pindah_masuk.edit', compact('perpindahan',  'rt'));
    }

    public function update(Request $request, Perpindahan $perpindahan)
    {
        $validateData = $request->validate([
            'tanggal_pelaporan' => 'required|date',
            'klasifikasi' => 'required|string|max:255',
            'alamat_tujuan' => 'required|string|max:255',
            'rt_tujuan' => 'required',
            'rw_tujuan' => "required",
            'alamat_asal' => 'required|string|max:255',
            'desa_asal' => 'required|string|max:255',
            'kecamatan_asal' => 'required|string|max:255',
            'kabupaten_asal' => 'required|string|max:255',
            'provinsi_asal' => 'required|string|max:255',
            'alasan' => 'required|string|max:255',
        ]);

      
        $perpindahan->update([
            'jenis_perpndahan' => 'pindah masuk',
            'alamat_asal' => $request->alamat_asal,
            'desa_asal' => $request->desa_asal,
            'kecamatan_asal' => $request->kecamatan_asal,
            'kabupaten_asal' => $request->kabupaten_asal,
            'provinsi_asal' => $request->provinsi_asal,
            'alamat_tujuan' => $request->alamat_tujuan,
            'rt_tujuan' => $request->rt_tujuan,
            'rw_tujuan' => $request->rw_tujuan,
            'klasifikasi_perpindahan' => $request->klasifikasi,
            'tanggal_pelaporan' => $request->tanggal_pelaporan,
            'alasan_perpindahan' => $request->alasan,
        ]);

        return redirect()->route('pindah_masuk', $perpindahan->mutasiPenduduk->penduduk->rt->rw->no_rw)->with('updated', 'penduduk telah diacatat ulang');
    }

    public function destroy(Perpindahan $perpindahan)
    {

        

        $perpindahan->mutasiPenduduk->delete();

        return redirect()->route('pindah_masuk', $perpindahan->mutasiPenduduk->penduduk->rt->rw->no_rw)->with('deleted', 'catatan penduduk telah di hapus');
    }
}