<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $fillable = [
        'nama',

    ];

    public function surats()
    {
        return $this->hasMany(Surat::class);
    }

    public function pegawai()
    {
        return $this->hasMany(pegawai::class);
    }
}
