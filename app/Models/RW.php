<?php

namespace App\Models;

use App\Models\Dusun;
use App\Models\Penduduk;
use App\Models\RT;
use Illuminate\Database\Eloquent\Model;

class RW extends Model
{
    protected $table = 'rw';

    protected $fillable = [
        'dusun_id',
        'ketua_rw',
        'no_rw',
    ];

    public function dusun()
    {
        return $this->belongsTo(Dusun::class, 'dusun_id');
    }

    public function rt()
    {
        return $this->hasMany(RT::class, 'rw_id');
    }

    public function penduduk()
    {
        return $this->hasManyThrough(
            Penduduk::class,
            RT::class,
            'rw_id', // FK di RT
            'rt_id', // FK di Penduduk
            'id',    // PK di RW
            'id'     // PK di RT
        );
    }

    public function keluarga()
    {
        return $this->hasManyThrough(
            Keluarga::class,
            RT::class,
            'rw_id',
            'rt_id',
            'id',
            'id'
        );
    }
}