<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surats';



    // Relasi ke model Divisi
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}
