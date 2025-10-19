<?php

namespace Database\Factories;

use App\Models\Pasien;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\anamnesis>
 */
class AnamnesisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'pasien_id' => Pasien::inRandomOrder()->first()->id,
        'kehamilan' => fake()->randomElement(['Primigravida', 'Multigravida', 'Nulligravida']),
        'takikardia' => fake()-> boolean(),
        'hipertensi' => fake()-> boolean(),
        'transfusi_darah'=> fake()-> boolean(),
        'kebiasaan_merokok' => fake()->randomElement(['Pasif', 'Aktif', 'Tidak Merokok']),
        'keluhan' => $keluhan = fake()->paragraph(),
        ];
    }
}
