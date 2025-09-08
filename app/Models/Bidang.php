<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bidang';
    protected $fillable = [
        'nama',

    ];

    public function pegawai()
    {
        return $this->hasMany(pegawai::class);
    }
}
