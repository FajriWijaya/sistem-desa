<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dusun;
use Illuminate\Http\Request;

class DusunController extends Controller
{
    public function index()
    {
        $dusun = Dusun::with(['rw.rt'])

            ->latest()->get()
            ->map(function ($item) {
                $item->jumlah_rt = $item->rw->sum(fn($rw) => $rw->rt->count());
                return $item;
            });
        // dd($dusun);
        return view('dusun.index', compact('dusun'));
    }

    public function store(Request $request)
    {

        // dd( $request->all());
        $request->validate([
            'nama_dusun' => "required|string|max:250"
        ]);

        Dusun::create($request->all());

        return redirect()->route('dusun')->with('created', 'Dusun berhasil ditambahkan');
    }

    public function update(Request $request, Dusun $dusun)
    {
        $request->validate([
            'nama_dusun' => "required|string|max:250"
        ]);

        $dusun->update($request->all());
        return redirect()->route('dusun')->with('updated', 'Dusun berhasil ditambahkan');
    }

    public function destroy(Dusun $dusun)
    {
        $dusun->delete();
        return redirect()->route('dusun')->with('deleted', 'Dusun berhasil ditambahkan');
    }
}