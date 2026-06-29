<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PendudukMasukExcel implements FromView
{
    protected $penduduk;
    protected $dusun;
    protected $tanggalMulai;
    protected $tanggalSelesai;
    protected $klasifikasi;

    public function __construct($penduduk, $dusun, $tanggalMulai = null, $tanggalSelesai = null, $klasifikasi = null)
    {
        $this->penduduk = $penduduk;
        $this->dusun = $dusun;
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalSelesai = $tanggalSelesai;
        $this->klasifikasi = $klasifikasi;
    }

    public function view(): View
    {
        return view('exports.pindah_masuk_excel', [
            'penduduk' => $this->penduduk,
            'dusun' => $this->dusun,
            'tanggalMulai' => $this->tanggalMulai,
            'tanggalSelesai' => $this->tanggalSelesai,
            'klasifikasi' => $this->klasifikasi,
            'tanggal_cetak' => now(),
        ]);
    }
}