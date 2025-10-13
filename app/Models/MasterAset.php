<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAset extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_aset';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jenis_kib',
        'kode_barang',
        'nama_barang',
        'spesifikasi_barang',
        'nilai_perolehan_rp',
        'tahun_perolehan',
        'keterangan',
        'foto_barang',
        'nomor_induk_barang',
        'nomor_register',
        'spesifikasi_lainnya',
        'luas',
        'satuan',
        'lokasi_alamat',
        'hak',
        'nomor_sertifikat',
        'tanggal_sertifikat',
        'nama_kepemilikan',
        'cara_perolehan',
        'status_pengguna',
        'umur_ekonomis_tahun',
        'akumulasi_penyusutan_awal',
        'beban_penyusutan_tahunan',
        'akumulasi_penyusutan_akhir',
        'nilai_buku',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nilai_perolehan_rp' => 'decimal:2',
        'luas' => 'decimal:2',
        'akumulasi_penyusutan_awal' => 'decimal:2',
        'beban_penyusutan_tahunan' => 'decimal:2',
        'akumulasi_penyusutan_akhir' => 'decimal:2',
        'nilai_buku' => 'decimal:2',
        'tanggal_sertifikat' => 'date',
    ];
}
