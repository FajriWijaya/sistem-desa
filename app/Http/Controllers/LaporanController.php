<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function bulanan(Request $request)
    {
        // =========================
        // INPUT BULAN & TAHUN
        // =========================
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $start = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $end   = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        // akhir bulan sebelumnya
        $lastMonthEnd = $start->copy()->subMonth()->endOfMonth();

        // =========================
        // DATA AWAL
        // Penduduk aktif sampai akhir bulan sebelumnya
        // =========================
        $awal = DB::table('penduduk as p')
            ->join('rt', 'p.rt_id', '=', 'rt.id')
            ->join('rw', 'rt.rw_id', '=', 'rw.id')
            ->join('dusun', 'rw.dusun_id', '=', 'dusun.id')

            ->select(
                'dusun.id',

                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(p.jenis_kelamin)) = 'laki-laki'
                            THEN 1 ELSE 0
                        END
                    ) as awal_l
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(p.jenis_kelamin)) = 'perempuan'
                            THEN 1 ELSE 0
                        END
                    ) as awal_p
                ")
            )

            // EXCLUDE meninggal / pindah keluar sebelum bulan laporan
            ->whereNotExists(function ($q) use ($lastMonthEnd) {
                $q->select(DB::raw(1))
                    ->from('mutasi_penduduk as m')
                    ->whereColumn('m.penduduk_id', 'p.id')

                    ->whereRaw("
                        LOWER(TRIM(m.jenis_mutasi)) = 'pengurangan'
                    ")

                    ->whereRaw("
                        LOWER(TRIM(m.keterangan))
                        IN ('meninggal', 'pindah keluar')
                    ")

                    ->whereDate('m.tanggal_mutasi', '<=', $lastMonthEnd);
            })

            // EXCLUDE kelahiran / pindah masuk bulan ini
            ->whereNotExists(function ($q) use ($start, $end) {
                $q->select(DB::raw(1))
                    ->from('mutasi_penduduk as m')
                    ->whereColumn('m.penduduk_id', 'p.id')

                    ->whereRaw("
                        LOWER(TRIM(m.jenis_mutasi)) = 'penambahan'
                    ")

                    ->whereRaw("
                        LOWER(TRIM(m.keterangan))
                        IN ('kelahiran', 'pindah masuk')
                    ")

                    ->whereBetween('m.tanggal_mutasi', [
                        $start->toDateString(),
                        $end->toDateString()
                    ]);
            })

            ->groupBy('dusun.id')
            ->get()
            ->keyBy('id');

        // =========================
        // DATA MUTASI BULAN INI
        // =========================
        $mutasi = DB::table('mutasi_penduduk as m')
            ->join('penduduk as p', 'm.penduduk_id', '=', 'p.id')
            ->join('rt', 'p.rt_id', '=', 'rt.id')
            ->join('rw', 'rt.rw_id', '=', 'rw.id')
            ->join('dusun', 'rw.dusun_id', '=', 'dusun.id')

            ->select(
                'dusun.id',

                // =========================
                // LAHIR
                // =========================
                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(m.keterangan)) = 'kelahiran'
                            AND LOWER(TRIM(m.jenis_mutasi)) = 'penambahan'
                            AND LOWER(TRIM(p.jenis_kelamin)) = 'laki-laki'
                            THEN 1 ELSE 0
                        END
                    ) as lahir_l
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(m.keterangan)) = 'kelahiran'
                            AND LOWER(TRIM(m.jenis_mutasi)) = 'penambahan'
                            AND LOWER(TRIM(p.jenis_kelamin)) = 'perempuan'
                            THEN 1 ELSE 0
                        END
                    ) as lahir_p
                "),

                // =========================
                // DATANG
                // =========================
                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(m.keterangan)) = 'pindah masuk'
                            AND LOWER(TRIM(m.jenis_mutasi)) = 'penambahan'
                            AND LOWER(TRIM(p.jenis_kelamin)) = 'laki-laki'
                            THEN 1 ELSE 0
                        END
                    ) as datang_l
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(m.keterangan)) = 'pindah masuk'
                            AND LOWER(TRIM(m.jenis_mutasi)) = 'penambahan'
                            AND LOWER(TRIM(p.jenis_kelamin)) = 'perempuan'
                            THEN 1 ELSE 0
                        END
                    ) as datang_p
                "),

                // =========================
                // MENINGGAL
                // =========================
                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(m.keterangan)) = 'meninggal'
                            AND LOWER(TRIM(m.jenis_mutasi)) = 'pengurangan'
                            AND LOWER(TRIM(p.jenis_kelamin)) = 'laki-laki'
                            THEN 1 ELSE 0
                        END
                    ) as meninggal_l
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(m.keterangan)) = 'meninggal'
                            AND LOWER(TRIM(m.jenis_mutasi)) = 'pengurangan'
                            AND LOWER(TRIM(p.jenis_kelamin)) = 'perempuan'
                            THEN 1 ELSE 0
                        END
                    ) as meninggal_p
                "),

                // =========================
                // PINDAH KELUAR
                // =========================
                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(m.keterangan)) = 'pindah keluar'
                            AND LOWER(TRIM(m.jenis_mutasi)) = 'pengurangan'
                            AND LOWER(TRIM(p.jenis_kelamin)) = 'laki-laki'
                            THEN 1 ELSE 0
                        END
                    ) as pindah_l
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN LOWER(TRIM(m.keterangan)) = 'pindah keluar'
                            AND LOWER(TRIM(m.jenis_mutasi)) = 'pengurangan'
                            AND LOWER(TRIM(p.jenis_kelamin)) = 'perempuan'
                            THEN 1 ELSE 0
                        END
                    ) as pindah_p
                ")
            )

            ->whereDate('m.tanggal_mutasi', '>=', $start->toDateString())
            ->whereDate('m.tanggal_mutasi', '<=', $end->toDateString())

            ->groupBy('dusun.id')
            ->get()
            ->keyBy('id');

        // =========================
        // SEMUA DUSUN
        // =========================
        $dusunList = DB::table('dusun')
            ->orderBy('nama_dusun')
            ->get();

        $data = [];

        foreach ($dusunList as $d) {

            $awal_l = $awal[$d->id]->awal_l ?? 0;
            $awal_p = $awal[$d->id]->awal_p ?? 0;

            $m = $mutasi[$d->id] ?? null;

            $lahir_l     = $m->lahir_l ?? 0;
            $lahir_p     = $m->lahir_p ?? 0;

            $datang_l    = $m->datang_l ?? 0;
            $datang_p    = $m->datang_p ?? 0;

            $meninggal_l = $m->meninggal_l ?? 0;
            $meninggal_p = $m->meninggal_p ?? 0;

            $pindah_l    = $m->pindah_l ?? 0;
            $pindah_p    = $m->pindah_p ?? 0;

            // =========================
            // TOTAL AKHIR
            // =========================
            $akhir_l =
                $awal_l +
                $lahir_l +
                $datang_l -
                $meninggal_l -
                $pindah_l;

            $akhir_p =
                $awal_p +
                $lahir_p +
                $datang_p -
                $meninggal_p -
                $pindah_p;

            $data[] = (object)[

                'nama_dusun' => $d->nama_dusun,

                // AWAL
                'awal_l' => $awal_l,
                'awal_p' => $awal_p,
                'total_awal' => $awal_l + $awal_p,

                // LAHIR
                'lahir_l' => $lahir_l,
                'lahir_p' => $lahir_p,

                // DATANG
                'datang_l' => $datang_l,
                'datang_p' => $datang_p,

                // MENINGGAL
                'meninggal_l' => $meninggal_l,
                'meninggal_p' => $meninggal_p,

                // PINDAH
                'pindah_l' => $pindah_l,
                'pindah_p' => $pindah_p,

                // AKHIR
                'akhir_l' => $akhir_l,
                'akhir_p' => $akhir_p,
                'total_akhir' => $akhir_l + $akhir_p,
            ];
        }

        $data = collect($data);

        return view('laporan.index', compact(
            'data',
            'bulan',
            'tahun'
        ));
    }

    public function print(Request $requets){
        $view = $this->bulanan($requets);
        
        $data = $view->getData()['data'];
        $bulan = $view->getData()['bulan'];
        $tahun = $view->getData()['tahun'];

        return  view('Laporan.print', compact('data','bulan' , 'tahun'));
    }
 
}