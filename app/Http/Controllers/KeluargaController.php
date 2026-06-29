<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use App\Models\Dusun;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\RT;
use App\Models\RW;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    public function index(RW $rw)
    {
        $keluarga = Keluarga::with(['kepalaKeluarga', 'rt.rw'])
            ->whereHas('rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            })
            ->get();
        // dd($keluarga);
        return view('keluarga.index', compact('keluarga', 'rw'));
    }

    public function rw()
    {

        $rw = RW::withCount([
            'keluarga as jumlah_keluarga'
        ])->get();
        // dd($dusun);

        return view('keluarga.rw', compact('rw'));
    }

    public function show(Keluarga $keluarga)
    {
        $penduduk = Penduduk::with('rt.rw')
            ->whereHas('rt', function ($query) use ($keluarga) {
                $query->where('rw_id', $keluarga->rt->rw_id);
            })->cursor();
        $keluarga->load([
            'rt.rw',
            'anggotaKeluarga.penduduk.rt.rw'
        ]);
        $rw = $keluarga->rt->rw;
        $anggota = $keluarga->anggotaKeluarga;
        return view('keluarga.show', compact('keluarga', 'anggota', 'rw', 'penduduk'));
    }

    public function storeAnggotaKeluarga(Request $request, Keluarga $keluarga)
    {
        $validatedData = $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'hubungan' => 'required|string|in:kepala keluarga,suami,istri,anak,cucu,orang tua',
        ]);

        $keluarga->anggotaKeluarga()->create([
            'penduduk_id' => $validatedData['penduduk_id'],
            'hubungan' => $validatedData['hubungan']
        ]);

        return redirect()->route('keluarga.show', $keluarga->id)->with('created', 'Anggota keluarga berhasil ditambahkan.');
    }

    public function updateAnggotaKeluarga(AnggotaKeluarga $anggota, Request $request)
    {
        $validatedData = $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'hubungan' => 'required|string|in:kepala keluarga,suami,istri,anak,cucu,orang tua',
        ]);
        $anggota->update([
            'penduduk_id' => $validatedData['penduduk_id'],
            'hubungan' => $validatedData['hubungan']
        ]);
        return redirect()->route('keluarga.show', $anggota->keluarga->id)->with('updated', 'Anggota keluarga berhasil diperbarui.');
    }

    public function destroyAnggotaKeluarga(AnggotaKeluarga $anggota)
    {
        $anggota->delete();
        return redirect()->route('keluarga.show', $anggota->keluarga->id)->with('deleted', 'Anggota keluarga berhasil dihapus.');
    }

    public function edit(Keluarga $keluarga)
    {
        $kepalaKeluarga = Penduduk::where('jenis_kelamin', 'laki-laki')
            ->whereDoesntHave('kepalaKeluarga')
            ->whereHas('rt', function ($query) use ($keluarga) {
                $query->where('rw_id', $keluarga->rt->rw_id);
            })
            ->orWhere('id', $keluarga->kepala_keluarga_id)
            ->get();
        $rt = RT::where('rw_id', $keluarga->rt->rw_id)->get();
        $rw = $keluarga->rt->rw;
        return view('keluarga.edit', compact('keluarga', 'kepalaKeluarga', 'rt', 'rw'));
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $validatedData = $request->validate([
            'kepala_keluarga_id' => 'required|exists:penduduk,id',
            'alamat' => 'required|string',
            'rt_id' => 'required|exists:rt,id',
        ]);

        $keluarga->update($validatedData);

        return redirect()->route('keluarga', $keluarga->rt->rw->no_rw)->with('updated', 'Keluarga berhasil diperbarui.');
    }

    public function create(RW $rw)
    {
        $kepalaKeluarga = Penduduk::where('jenis_kelamin', 'laki-laki')
            ->whereDoesntHave('kepalaKeluarga')
            ->whereHas('rt', function ($query) use ($rw) {
                $query->where('rw_id', $rw->id);
            })
            ->get();
        $rt = $rw->rt;
        return view('keluarga.create', compact('rw', 'kepalaKeluarga', 'rt'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_kk' => 'required|string|unique:keluarga,no_kk',
            'kepala_keluarga_id' => 'required|exists:penduduk,id',
            'alamat' => 'required|string',
            'rt_id' => 'required|exists:rt,id',
        ]);

        $keluarga = Keluarga::create($validatedData);

        return redirect()->route('keluarga', $keluarga->rt->rw->no_rw)->with('created', 'Keluarga berhasil ditambahkan.');
    }
}