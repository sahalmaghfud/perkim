<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahTidakLayakHuni extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rumah_tidak_layak_huni';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kepala_ruta',
        'nik',
        'umur',
        'alamat',
        'luas_rumah',
        'kode_wilayah',
        'kecamatan',
        'desa_kelurahan',
        'jenis_kelamin',
        'kepemilikan_tanah',
        'no_sertifikat',
        'kondisi_lantai',
        'kondisi_dinding',
        'kondisi_atap', // Kolom baru
        'sumber_air',
        'sanitasi_wc',
        'dapur',
        'koordinat',
        'foto_rumah', // Diganti dari foto_sebelum_perbaikan
        'foto_kondisi_lantai', // Kolom baru
        'foto_kondisi_dinding', // Kolom baru
        'foto_kondisi_atap', // Kolom baru
        'foto_sanitasi_wc', // Kolom baru
        'foto_kondisi_dapur', // Kolom baru
    ];
}

