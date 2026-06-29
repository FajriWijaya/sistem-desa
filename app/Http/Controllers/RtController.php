<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\RT;
use App\Models\RW;
use Illuminate\Http\Request;

class RtController extends Controller
{
    public function index(RW $rw)
    {
        $rw->load('rt', 'dusun');
        $rt = $rw->rt;
        return view('dusun.RT', compact('rw', 'rt'));
    }

    public function store(Request $requset)
    {
        $requset->validate([
            'rw_id' => 'required|exists:rw,id',
            'no_rt' => 'required|numeric|unique:rt,no_rt',
            'ketua_rt' => 'required|string'
        ]);

        $rt = RT::create($requset->all());
        return redirect()->route('dusun.rw.rt', $rt->rw->id)->with('created', 'RW berhasil ditambahlan');
    }

    public function update(Request $request, RT $rt)
    {

    // dd($request->all());
    
        $request->validate([
            'no_rt' => 'required|numeric',
            'ketua_rt' => 'required|string'
        ]);

        $rt->update($request->all());
        return redirect()->route('dusun.rw.rt', $rt->rw->id)->with('updated', 'Data rw berhasil di ubah');
    }

    public function destroy(RT $rt)
    {
        $rt->delete();
        return redirect()->route('dusun.rw.rt', $rt->rw->id)->with('deletwd', 'Data rw berhasil di hapus');
    }
}