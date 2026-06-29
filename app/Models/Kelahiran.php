<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelahiran extends Model
{
    protected $table = 'kelahiran';

    protected $guarded = ['id'];

    public function mutasiPenduduk()
    {
        return $this->belongsTo(MutasiPenduduk::class, 'mutasi_penduduk_id');
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_id');
    }

    public function ayah(){
        return $this->belongsTo(Penduduk::class, 'ayah_id');
    }

    
    public function ibu(){
        return $this->belongsTo(Penduduk::class, 'ibu_id');
    }
}