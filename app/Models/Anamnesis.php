<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function pemeriksaans():HasMany{
        return $this->hasMany(Pemeriksaan::class, 'anamnesis_id');
    }
}
