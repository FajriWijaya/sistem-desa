<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kematian extends Model
{
    protected $table = 'kematians';

    protected $guarded = ['id'];

    public function mutasiPenduduk()
    {
        return $this->belongsTo(MutasiPenduduk::class, 'mutasi_penduduk_id');
    }
}