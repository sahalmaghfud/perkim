<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JalanLingkungan extends Model
{
    use HasFactory;
    protected $table = 'jalan_lingkungan';

    protected $fillable = [
        'cv_id',
        'uraian',
        'volume',
        'satuan',
        'harga_satuan',
        'jumlah_harga',
        'nomor_kontrak',
        'tanggal_kontrak',
        'tanggal_awal_pekerjaan',
        'tanggal_akhir_pekerjaan',
        'nilai_kontrak',
        'no_spm_30',
        'no_sp2d_30',
        'tanggal_30',
        'nilai_30',
        'ppn_30',
        'pph_30',
        'total_30',
        'no_spm_95',
        'no_sp2d_95',
        'tanggal_95',
        'nilai_95',
        'ppn_95',
        'pph_95',
        'total_95',
        'no_spm_100',
        'no_sp2d_100',
        'tanggal_100',
        'nilai_100',
        'ppn_100',
        'pph_100',
        'total_100',
        'baphp_nomor',
        'baphp_tanggal',
        'bast_nomor',
        'bast_tanggal',
        'keterangan',
    ];

    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class);
    }

    // Accessor untuk rekapitulasi (tetap sama)
    protected function totalKeseluruhan(): Attribute
    {
        return Attribute::make(
            get: fn() => ($this->total_30 ?? 0) + ($this->total_95 ?? 0) + ($this->total_100 ?? 0),
        );
    }
}
