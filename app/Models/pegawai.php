<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pegawai';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bidang_id',
        'pangkat_id',
        'nama',
        'nip',
        'golongan',
        'foto',
        'tmt_cpns',
        'tmt_pangkat',
        'nama_jabatan',
        'eselon',
        'tmt_jabatan',
        'nama_diklat',
        'tahun_diklat',
        'jumlah_jam_diklat',
        'pendidikan_terakhir',
        'jurusan',
        'tahun_lulus',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'catatan_mutasi',
        'keterangan',
        'nama_univ',
        'berkala_terakhir',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'tmt_cpns' => 'date',
    //     'tmt_pangkat' => 'date',
    //     'tmt_jabatan' => 'date',
    //     'tahun_diklat' => 'integer',
    //     'tahun_lulus' => 'integer',
    //     'jumlah_jam_diklat' => 'integer',
    // ];

    /**
     * Get the bidang that owns the pegawai.
     * Asumsi ada model Bidang.
     */
    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class);
    }

    /**
     * Get the pangkat that owns the pegawai.
     */
    public function pangkat(): BelongsTo
    {
        return $this->belongsTo(Pangkat::class);
    }

    /**
     * Get the dokumen for the pegawai.
     */
    public function dokumenPegawai(): HasMany
    {
        return $this->hasMany(DokumenPegawai::class);
    }
}
