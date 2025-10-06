<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemeriksaan extends Model
{
    /** @use HasFactory<\Database\Factories\PemeriksaanFactory> */
    use HasFactory;
    protected $fillable = [
        'heart_rate',
        'spo2',
        'status_anemia'
    ];
    protected $with = ['pasien', 'anamnesis'];
    public function pasien():BelongsTo{
        return $this->belongsTo(Pasien::class);
    }
    public function anamnesis():BelongsTo{
        return $this->belongsTo(Anamnesis::class);
    }
    protected function scopeFilter(Builder $query, array $filters): void{
        $query->when($filters['search'] ?? false,
        fn ($query, $search)=>
            $query->wherehas('pasien',  fn ($query) => $query->where('name', 'like', '%'  . $search . '%'))
        );
        $query->when($filters['pasien'] ?? false,
        fn ($query, $category)=>
                $query->whereHas('pasien', fn($query) => $query->where('slug', $category))
        );
        // $query->when($filters['author'] ?? false,
        // fn ($query, $author)=>
        //         $query->whereHas('author', fn($query) => $query->where('username', $author))
        // );
    }
}
