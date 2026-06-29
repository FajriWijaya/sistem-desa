<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $table = 'penduduk';

    protected $guarded = ['id'];

    public function mutasiPenduduk()
    {
        return $this->hasMany(MutasiPenduduk::class, 'penduduk_id');
    }


    public function kepalaKeluarga()
    {
        return $this->hasOne(Keluarga::class, 'kepala_keluarga_id');
    }

    public function rt()
    {
        return $this->belongsTo(RT::class, 'rt_id');
    }

    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'penduduk_id');
    }

    public function keluarga()
    {
        return $this->hasOneThrough(
            Keluarga::class,
            AnggotaKeluarga::class,
            'penduduk_id', // FK di AnggotaKeluarga
            'id',          // PK di Keluarga
            'id',          // PK di Penduduk
            'keluarga_id'  // FK di AnggotaKeluarga
        );
    }
}