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
    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'jenis_surat',
        'pengirim',
        'penerima',
        'perihal',
        'sifat',
        'file_path',
        'divisi_id'
    ];
}
