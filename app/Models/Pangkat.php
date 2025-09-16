<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pangkat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pangkat';

    /**
     * Indicates if the model should be timestamped.
     * Karena tidak ada timestamps() di migrasi.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pangkat',
        'golongan',
        'ruang',
    ];

    /**
     * Get the pegawai for the pangkat.
     */
    public function pegawais(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}
