<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    /** @use HasFactory<\Database\Factories\PasienFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'tempat_lahir',
        'tanggal_lahir',
        'phone_number'
    ];
    public function pemeriksaans(): HasMany{
        return $this->hasMany(Pemeriksaan::class, 'pasien_id');
    }
    public function anamneses(): HasMany{
        return $this->hasMany(Anamnesis::class, 'pasien_id');
    }
}