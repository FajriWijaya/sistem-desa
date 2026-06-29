<?php

namespace App\Models;

use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Model;

class Dusun extends Model
{
    protected $table = 'dusun';

    protected $fillable = [
        'nama_dusun',
        'rw',
        'kepala_rw',
    ];

    public function penduduk()
    {
        return $this->hasMany(Penduduk::class, 'dusun_id');
    }

    public function rw(){
      return $this->hasMany(RW::class, 'dusun_id');   
    }
}