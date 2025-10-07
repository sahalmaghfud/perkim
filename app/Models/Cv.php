<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cv extends Model
{
    use HasFactory;
    protected $table = 'cv';
    protected $fillable = ['nama_cv', 'npwp', 'nomor_rekening', 'nama_direktur'];

    public function JalanLingkungan(): HasMany
    {
        return $this->hasMany(JalanLingkungan::class, 'cv_id');
    }
}
