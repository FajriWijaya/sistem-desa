<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perpindahan extends Model
{
    protected $table = 'perpindahan';

    protected $guarded = ['id'];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function mutasiPenduduk()
    {
        return $this->belongsTo(MutasiPenduduk::class, 'mutasi_penduduk_id');
    }
    
}