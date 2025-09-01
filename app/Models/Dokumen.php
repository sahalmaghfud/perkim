<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumens';
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    protected $fillable = [
        'kode_dokumen',
        'judul',
        'kategori',
        'tipe_dokumen',
        'deskripsi',
        'tanggal_terbit',
        'file_path',
        'divisi_id',
    ];

    // Relasi ke model Divisi

}
