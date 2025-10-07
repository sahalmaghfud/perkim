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
        'kode_wilayah',
        'kecamatan',
        'desa_kelurahan',
        'alamat',
        'jenis_kelamin',
        'kategori_rumah',
        'luas_rumah',
        'kepemilikan_rumah',
        'kepemilikan_tanah',
        'foto_sebelum_perbaikan',
        'foto_sesudah_perbaikan',
        'koordinat',
        'status',
    ];
}
