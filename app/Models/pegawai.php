<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class pegawai extends Model
{
    protected $table = 'pegawai';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'nama_lengkap',
        'divisi_id',
        'jabatan',
        'email',
        'nomor_telepon',
        'alamat',
        'tanggal_lahir',
        'tanggal_masuk',
        'status',
    ];
    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }
}
