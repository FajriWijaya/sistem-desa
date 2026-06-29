<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\RW;
use Illuminate\Support\Facades\DB;

class DashboardContoller extends Controller
{
    public function index()
    {
        // =========================
        // DATA CARD
        // =========================
        $jumlahPenduduk = RW::withCount([
            'penduduk as jumlah_penduduk' => function ($query) {
                $query->where('status_kependudukan', 'aktif');
            }
        ])->get();

        $jumlahKeluarga = Keluarga::count();

        $kematian = RW::withCount([
            'penduduk as jumlah_kematian' => function ($query) {
                $query->whereHas('mutasiPenduduk', function ($q) {
                    $q->where('jenis_mutasi', 'pengurangan')
                        ->where('keterangan', 'meninggal');
                });
            }
        ])->get();

        $kelahiran = RW::withCount([
            'penduduk as jumlah_kelahiran' => function ($query) {
                $query->whereHas('mutasiPenduduk', function ($q) {
                    $q->where('jenis_mutasi', 'penambahan')
                        ->where('keterangan', 'kelahiran');
                });
            }
        ])->get();

        $perpindahanDatang = RW::withCount([
            'penduduk as jumlah_penduduk' => function ($query) {
                $query->whereHas('mutasiPenduduk', function ($q) {
                    $q->where('jenis_mutasi', 'penambahan')
                        ->where('keterangan', 'pindah masuk');
                });
            }
        ])->get();

        $perpindahanKeluar = RW::withCount([
            'penduduk as jumlah_penduduk' => function ($query) {
                $query->whereHas('mutasiPenduduk', function ($q) {
                    $q->where('jenis_mutasi', 'pengurangan')
                        ->where('keterangan', 'pindah keluar');
                });
            }
        ])->get();

        return view('dashboard.index', [
            'jumlahPenduduk' => $jumlahPenduduk,
            'kematian' => $kematian,
            'kelahiran' => $kelahiran,
            'perpindahanDatang' => $perpindahanDatang,
            'perpindahanKeluar' => $perpindahanKeluar,
            'jumlahKeluarga' => $jumlahKeluarga,
        ]);
    }

    public function chartData()
    {
        // ================= BULAN =================
        $perBulan = DB::table('penduduk')
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('status_kependudukan', 'aktif')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $dataBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataBulan[] = $perBulan[$i] ?? 0;
        }

        // ================= TAHUN =================
        $perTahun = DB::table('penduduk')
            ->selectRaw('YEAR(created_at) as tahun, COUNT(*) as total')
            ->where('status_kependudukan', 'aktif')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->pluck('total', 'tahun');

        return response()->json([
            'bulan' => $dataBulan,
            'tahun' => array_values($perTahun->toArray()),
            'labelTahun' => array_keys($perTahun->toArray()),
        ]);
    }

    public function chartMutasi()
    {
        // ====== PER BULAN (tahun berjalan) ======
        $perBulan = DB::table('mutasi_penduduk')
            ->selectRaw("
            MONTH(tanggal_mutasi) as periode,
            SUM(CASE WHEN keterangan = 'kelahiran' THEN 1 ELSE 0 END) as kelahiran,
            SUM(CASE WHEN keterangan = 'meninggal' THEN 1 ELSE 0 END) as meninggal,
            SUM(CASE WHEN keterangan = 'pindah masuk' THEN 1 ELSE 0 END) as masuk,
            SUM(CASE WHEN keterangan = 'pindah keluar' THEN 1 ELSE 0 END) as keluar
        ")
            ->whereYear('tanggal_mutasi', now()->year)
            ->groupBy('periode')
            ->orderBy('periode')
            ->get()
            ->keyBy('periode');

        // isi 1–12 biar tidak bolong
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $seriesBulan = [
            'kelahiran' => [],
            'meninggal' => [],
            'masuk'     => [],
            'keluar'    => [],
        ];

        for ($i = 1; $i <= 12; $i++) {
            $row = $perBulan[$i] ?? null;
            $seriesBulan['kelahiran'][] = $row->kelahiran ?? 0;
            $seriesBulan['meninggal'][] = $row->meninggal ?? 0;
            $seriesBulan['masuk'][]     = $row->masuk ?? 0;
            $seriesBulan['keluar'][]    = $row->keluar ?? 0;
        }

        // ====== PER TAHUN ======
        $perTahun = DB::table('mutasi_penduduk')
            ->selectRaw("
            YEAR(tanggal_mutasi) as periode,
            SUM(CASE WHEN keterangan = 'kelahiran' THEN 1 ELSE 0 END) as kelahiran,
            SUM(CASE WHEN keterangan = 'meninggal' THEN 1 ELSE 0 END) as meninggal,
            SUM(CASE WHEN keterangan = 'pindah masuk' THEN 1 ELSE 0 END) as masuk,
            SUM(CASE WHEN keterangan = 'pindah keluar' THEN 1 ELSE 0 END) as keluar
        ")
            ->groupBy('periode')
            ->orderBy('periode')
            ->get();

        $labelTahun = $perTahun->pluck('periode')->values();
        $seriesTahun = [
            'kelahiran' => $perTahun->pluck('kelahiran')->values(),
            'meninggal' => $perTahun->pluck('meninggal')->values(),
            'masuk'     => $perTahun->pluck('masuk')->values(),
            'keluar'    => $perTahun->pluck('keluar')->values(),
        ];

        return response()->json([
            'bulan' => [
                'labels' => $bulanLabels,
                'series' => $seriesBulan
            ],
            'tahun' => [
                'labels' => $labelTahun,
                'series' => $seriesTahun
            ],
        ]);
    }
}