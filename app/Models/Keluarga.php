<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $table = 'keluarga';

    protected $guarded = ['id'];

    public function anggotaKeluarga()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'keluarga_id');

    }
    
      public function rt()
        {
            return $this->belongsTo(RT::class, 'rt_id');
        }

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Penduduk::class, 'kepala_keluarga_id');
    }
}