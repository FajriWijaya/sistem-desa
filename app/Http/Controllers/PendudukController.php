<?php

namespace App\Http\Controllers;

// use App\Models\AnggotaKeluarga;
use App\Http\Controllers\Controller;
use App\Models\Dusun;
use App\Models\Kelahiran;
use App\Models\Keluarga;
use App\Models\MutasiPenduduk;
use App\Models\Penduduk;
use App\Models\Perpindahan;
use App\Models\RW;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index(RW $rw)
    {
        $penduduk = Penduduk::with(['mutasiPenduduk', 'rt.rw'])->whereHas('rt', function ($query) use ($rw) {
            $query->where('rw_id', $rw->id);
        })->latest()->get();
        // dd($penduduk);
        $jumlahPenduduk = Penduduk::whereHas('rt', function ($quary) use ($rw) {
            $quary->where('rw_id', $rw->id);
        })->count();
        $jumlahKeluarga = Keluarga::whereHas('rt', function ($query) use ($rw) {
            $query->where('rw_id', $rw->id);
        })->count();
        $jumlahPendudukMeninggal = Penduduk::whereHas('rt', function ($quary) use ($rw) {
            $quary->where('rw_id', $rw->id);
        })->whereHas('mutasiPenduduk', function ($query) {
            $query->where('jenis_mutasi', 'pengurangan')
                ->where('keterangan', 'meninggal');
        })->count();
        $jumlahPendudukLahir = Penduduk::whereHas('rt', function ($quary) use ($rw) {
            $quary->where('rw_id', $rw->id);
        })->whereHas('mutasiPenduduk', function ($query) {
            $query->where('jenis_mutasi', 'penambahan')
                ->where('keterangan', 'kelahiran');
        })->count();

        $jumlahPendudukPindahDatang = Penduduk::whereHas('rt', function ($query) use ($rw) {
            $query->where('rw_id', $rw->id);
        })->whereHas('mutasiPenduduk', function ($query) {
            $query->where('jenis_mutasi', 'penambahan')
                ->where('keterangan', 'pindah datang');
        })->count();

        $jumlahPendudukPindahKeluar = Penduduk::whereHas('rt', function ($query) use ($rw) {
            $query->where('rw_id', $rw->id);
        })->whereHas('mutasiPenduduk', function ($query) {
            $query->where('jenis_mutasi', 'pengurangan')
                ->where('keterangan', 'pindah keluar');
        })->count();

        // dd($jumlahKeluarga, $jumlahPenduduk, $jumlahPendudukLahir, $jumlahPendudukMeninggal, $jumlahPendudukPindahDatang, $jumlahPendudukPindahDatang, $jumlahPendudukPindahKeluar);

        return view('penduduk.index', compact('penduduk', 'rw', 'jumlahPenduduk', 'jumlahKeluarga', 'jumlahPendudukMeninggal', 'jumlahPendudukLahir', 'jumlahPendudukPindahDatang', 'jumlahPendudukPindahKeluar'));
    }

    public function rw()
    {
        $rw = RW::withCount([
            'penduduk as jumlah_penduduk' => function ($query) {
                $query->where('status_kependudukan', 'aktif');
            }
        ])->get();

        // dd($dusun);

        return view('penduduk.rw', compact('rw'));
    }


    public function tambah(RW $rw)
    {
        $pendudukPria = Penduduk::whereHas('rt', function ($quary) use ($rw) {
            $quary->where('rw_id', $rw->id);
        })->where('jenis_kelamin', 'laki-laki')
        ->where('status_kependudukan', 'Menikah')
        ->get();
        $pendudukWanita = Penduduk::whereHas('rt', function ($quary) use ($rw) {
            $quary->where('rw_id', $rw->id);
        })->where('jenis_kelamin', 'perempuan')
        ->where('status_kependudukan', 'Menikah')
        ->get();
        return view('penduduk.create', compact('rw', 'pendudukPria', 'pendudukWanita'));
    }

    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'mutasi' => 'nullable|in:pindah_masuk,kelahiran',
            'nik' => 'required|string|max:16',
            'nama_ibu' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'rt_id' => 'required|string|max:255',
            'rw' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:255',
            'profesi' => 'required|string|max:255',
            'status_kependudukan' => 'nullable|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'status_perkawinan' => 'required|in:Belum Menikah,Menikah,Cerai Mati,Cerai Hidup',
            'golongan_darah' => 'required|in:A,B,AB,O',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'alamat_asal' => 'nullable|string|max:255',
            'desa_asal' => 'nullable|string|max:255',
            'kecamatan_asal' => 'nullable|string|max:255',
            'kabupaten_asal' => 'nullable|string|max:255',
            'provinsi_asal' => 'nullable|string|max:255',
            'klasifikasi_perpindahan' => 'nullable|string|max:255',
            'alasan_perpindahan' => 'nullable|string|max:255',
            'tanggal_pelaporan' => 'nullable|date',
            'ayah_id' => 'nullable|integer|exists:penduduk,id',
            'ibu_id' => 'nullable|integer|exists:penduduk,id',
            'waktu_lahir' => 'nullable|date_format:H:i',

        ]);





        $penduduk = Penduduk::firstOrCreate(['nik' => $validatedData['nik']], [
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'alamat' => $validatedData['alamat'],
            'tempat_lahir' => $validatedData['tempat_lahir'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'nama_ibu' => Penduduk::find($validatedData['ibu_id'])->nama_lengkap ?? $validatedData['nama_ibu'],
            'nama_ayah' => Penduduk::find($validatedData['ayah_id'])->nama_lengkap ?? $validatedData['nama_ayah'],
            'rt_id' => $validatedData['rt_id'],
            'agama' => $validatedData['agama'],
            'profesi' => $validatedData['profesi'],
            'pendidikan' => $validatedData['pendidikan'],
            'status_perkawinan' => $validatedData['status_perkawinan'],
            'golongan_darah' => $validatedData['golongan_darah'],
            'kewarganegaraan' => $validatedData['kewarganegaraan'],
        ]);

        if ($validatedData['mutasi'] == 'pindah_masuk') {
            $mutasi = MutasiPenduduk::create([
                'penduduk_id' => $penduduk->id,
                'jenis_mutasi' => 'penambahan',
                'keterangan' => 'pindah masuk'
            ]);

            Perpindahan::create([
                'mutasi_penduduk_id' => $mutasi->id,
                'jenis_perpindahan' => 'pindah masuk',
                'alamat_asal' => $validatedData['alamat_asal'],
                'desa_asal' => $validatedData['desa_asal'],
                'kecamatan_asal' => $validatedData['kecamatan_asal'],
                'kabupaten_asal' => $validatedData['kabupaten_asal'],
                'provinsi_asal' => $validatedData['provinsi_asal'],
                'alamat_tujuan' => $validatedData['alamat'],
                'rt_tujuan' => $penduduk->rt->no_rt,
                'rw_tujuan' => $validatedData['rw'],
                'klasifikasi_perpindahan' => $validatedData['klasifikasi_perpindahan'],
                'alasan_perpindahan' => $validatedData['alasan_perpindahan'],
                'tanggal_pelaporan' => $validatedData['tanggal_pelaporan'],
            ]);
        } else if ($validatedData['mutasi'] == 'Kelahiran') {
            $mutasi = MutasiPenduduk::create([
                'penduduk_id' => $penduduk->id,
                'jenis_mutasi' => 'penambahan',
                'keterangan' => 'kelahiran'
            ]);

            Kelahiran::create([
                'mutasi_penduduk_id' => $mutasi->id,
                'nik' => $validatedData['nik'],
                'ayah_id' => $validatedData['ayah_id'],
                'ibu_id' => $validatedData['ibu_id'],
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'tempat_lahir' => $validatedData['tempat_lahir'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'waktu_lahir' => $validatedData['waktu_lahir'],
            ]);
        }

        return redirect()->route('penduduk.index', $validatedData['rw'])->with('created', 'Penduduk berhasil ditambahkan.');
    }

    public function show(Penduduk $penduduk)
    {
        $penduduk->load(['rt.rw', 'mutasiPenduduk']);
        // dd($penduduk);
        return view('penduduk.show', compact('penduduk'));
    }

    public function edit(Penduduk $penduduk)
    {

        $rw = $penduduk->rt->rw;
        $pendudukPria = Penduduk::whereHas('rt', function ($quary) use ($rw) {
            $quary->where('rw_id', $rw->id);
        })->where('jenis_kelamin', 'laki-laki')->get();
        $pendudukWanita = Penduduk::whereHas('rt', function ($quary) use ($rw) {
            $quary->where('rw_id', $rw->id);
        })->where('jenis_kelamin', 'perempuan')->get();
        $penduduk->load(['rt.rw', 'mutasiPenduduk.perpindahan', 'mutasiPenduduk.kelahiran']);

        // dd($penduduk);
        return view('penduduk.edit', compact('penduduk', 'rw', 'pendudukPria', 'pendudukWanita'));
    }

    public function update(Penduduk $penduduk, Request $request)
    {

        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'mutasi' => 'nullable|in:pindah_masuk,kelahiran',
            'nik' => 'required|string|max:16',
            'nama_ibu' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'rt_id' => 'required|string|max:255',
            'rw' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:255',
            'profesi' => 'required|string|max:255',
            'status_kependudukan' => 'nullable|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'status_perkawinan' => 'required|in:Belum Menikah,Menikah,Cerai Mati,Cerai Hidup',
            'golongan_darah' => 'required|in:A,B,AB,O',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'alamat_asal' => 'nullable|string|max:255',
            'desa_asal' => 'nullable|string|max:255',
            'kecamatan_asal' => 'nullable|string|max:255',
            'kabupaten_asal' => 'nullable|string|max:255',
            'provinsi_asal' => 'nullable|string|max:255',
            'klasifikasi_perpindahan' => 'nullable|string|max:255',
            'alasan_perpindahan' => 'nullable|string|max:255',
            'tanggal_pelaporan' => 'nullable|date',
            'ayah_id' => 'nullable|integer|exists:penduduk,id',
            'ibu_id' => 'nullable|integer|exists:penduduk,id',
            'waktu_lahir' => 'nullable|date_format:H:i',

        ]);





        $penduduk->update(
            [
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'alamat' => $validatedData['alamat'],
                'tempat_lahir' => $validatedData['tempat_lahir'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'rt_id' => $validatedData['rt_id'],
                'agama' => $validatedData['agama'],
                'profesi' => $validatedData['profesi'],
                'pendidikan' => $validatedData['pendidikan'],
                'status_perkawinan' => $validatedData['status_perkawinan'],
                'golongan_darah' => $validatedData['golongan_darah'],
                'kewarganegaraan' => $validatedData['kewarganegaraan'],
            ]
        );

        if ($validatedData['mutasi'] == 'pindah_masuk') {
            $mutasi = MutasiPenduduk::where('penduduk_id', $penduduk->id)->first();
            $mutasi->update([
                'penduduk_id' => $penduduk->id,
                'jenis_mutasi' => 'penambahan',
                'keterangan' => 'pindah masuk'
            ]);

            $perpindahan = Perpindahan::where('mutasi_penduduk_id', $mutasi->id);
            $perpindahan->update([

                'jenis_perpindahan' => 'pindah masuk',
                'alamat_asal' => $validatedData['alamat_asal'],
                'desa_asal' => $validatedData['desa_asal'],
                'kecamatan_asal' => $validatedData['kecamatan_asal'],
                'kabupaten_asal' => $validatedData['kabupaten_asal'],
                'provinsi_asal' => $validatedData['provinsi_asal'],
                'alamat_tujuan' => $validatedData['alamat'],
                'rt_tujuan' => $penduduk->rt->no_rt,
                'rw_tujuan' => $validatedData['rw'],
                'klasifikasi_perpindahan' => $validatedData['klasifikasi_perpindahan'],
                'alasan_perpindahan' => $validatedData['alasan_perpindahan'],
                'tanggal_pelaporan' => $validatedData['tanggal_pelaporan'],
            ]);
        } else if ($validatedData['mutasi'] == 'Kelahiran') {
            $mutasi = MutasiPenduduk::where('penduduk_id', $penduduk->id)->first();
            $mutasi->update([
                'penduduk_id' => $penduduk->id,
                'jenis_mutasi' => 'penambahan',
                'keterangan' => 'kelahiran'
            ]);

            Kelahiran::create([
                'mutasi_penduduk_id' => $mutasi->id,
                'nik' => $validatedData['nik'],
                'ayah_id' => $validatedData['ayah_id'],
                'ibu_id' => $validatedData['ibu_id'],
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'tempat_lahir' => $validatedData['tempat_lahir'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'waktu_lahir' => $validatedData['waktu_lahir'],
            ]);
        }
        return redirect()->route('penduduk.index', $validatedData['rw'])->with('updated', 'Penduduk berhasil ditambahkan.');
    }



    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        return redirect()->route('penduduk.index', $penduduk->rt->rw->no_rw)->with('deleted', 'Penduduk berhasil dihapus.');
    }
}