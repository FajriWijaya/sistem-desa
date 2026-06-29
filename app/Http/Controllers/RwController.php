<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\RW;
use Illuminate\Http\Request;

class RwController extends Controller
{
    public function index(Dusun $dusun)
    {
        $dusun->load('rw.rt');
        $rw = $dusun->rw;
        return view('dusun.rw', compact('rw', 'dusun'));
    }

    public function store(Request $requset)
    {
        $requset->validate([
            'dusun_id' => 'required|exists:dusun,id',
            'no_rw' => 'required|numeric',
            'ketua_rw' => 'required|string'
        ]);

        $rw = RW::create($requset->all());
        return redirect()->route('dusun.rw', $rw->dusun->id)->with('created', 'RW berhasil ditambahlan');
    }

    public function update(Request $request, RW $rw)
    {
        $request->validate([
            'no_rw' => 'required|numeric',
            'ketua_rw' => 'required|string'
        ]);

        $rw->update($request->all());
        return redirect()->route('dusun.rw', $rw->dusun->id)->with('updated', 'Data rw berhasil di ubah');
    }

    public function destroy(RW $rw)
    {
        $rw->delete();
        return redirect()->route('dusun.rw', $rw->dusun->id)->with('deletwd', 'Data rw berhasil di hapus');
    }
}