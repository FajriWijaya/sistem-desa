<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RT extends Model
{
    protected $table = 'rt';

    protected $fillable = [
        'rw_id',
        'ketua_rt',
        'no_rt',
    ];

    public function rw()
    {
        return $this->belongsTo(RW::class, 'rw_id');
    }

    public function penduduk()
    {
        return $this->hasMany(Penduduk::class, 'rt_id');
    }
}