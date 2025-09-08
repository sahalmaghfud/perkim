<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumens';
    public function bidang()
    {
        return $this->belongsTo(bidang::class);
    }

    protected $fillable = [
        'judul',
        'kategori',
        'tipe_dokumen',
        'deskripsi',
        'tanggal',          // Diubah dari tanggal_terbit
        'file_path',
        'bidang_id',
        'nomor_surat',
        'pengirim',
        'penerima',
        'perihal',
        'lampiran',
        'tanggal_surat',
    ];

    // Relasi ke model bidang

}
