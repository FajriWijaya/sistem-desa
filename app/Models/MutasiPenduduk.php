<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiPenduduk extends Model
{
    protected $table = 'mutasi_penduduk';

    protected $guarded = ['id'];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function perpindahan()
    {
        return $this->hasOne(Perpindahan::class, 'mutasi_penduduk_id');
    }

    public function kelahiran()
    {
        return $this->hasOne(Kelahiran::class, 'mutasi_penduduk_id');
    }

    public function kematian()
    {
        return $this->hasOne(Kematian::class, 'mutasi_penduduk_id');
    }
}