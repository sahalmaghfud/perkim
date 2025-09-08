<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siteplan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'tipe',
        'luas_lahan_per_unit',
        'luas_lahan_perumahan',
        'luas_psu',
        'panjang_prasarana_jalan',
        'lebar_prasarana_jalan',
        'luas_prasarana_jalan',
        'luas_prasarana_drainase',
        'luas_prasarana_rth',
        'luas_prasarana_tps',
        'luas_sarana_pemakaman',
        'luas_sarana_olahraga_dll',
        'panjang_utilitas',
        'sumber_air_bersih',
        'jenis',
        'nama_pt',
        'jumlah_unit_rumah',
        'tahun',
        'alamat',
        'kecamatan',
        'desa',
        'nomor_site_plan',
        'tanggal_site_plan',
        'nomor_bast_adm',
        'tanggal_bast_adm',
        'nomor_bast_fisik',
        'tanggal_bast_fisik',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
}
