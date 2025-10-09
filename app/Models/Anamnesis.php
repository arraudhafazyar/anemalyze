<?php

namespace App\Models;

use App\Models\Pasien;
use App\Models\Pemeriksaan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anamnesis extends Model
{
    /** @use HasFactory<\Database\Factories\AnamnesisFactory> */
    use HasFactory;
    protected $fillable = [
        'kehamilan',
        'takikardia',
        'hipertensi',
        'transfusi_darah',
        'kebiasaan_merokok',
        'keluhan'
    ];
    public function pasien():BelongsTo{
        return $this->belongsTo(Pasien::class);
    }
    public function pemeriksaan(): HasOne
    {
        return $this->hasOne(Pemeriksaan::class);
    }

}
