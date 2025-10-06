<?php

namespace Database\Factories;

use App\Models\Pasien;
use App\Models\Anamnesis;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemeriksaan>
 */
class PemeriksaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {
        return [
        'pasien_id' => Pasien::factory(),
        'anamnesis_id' => Anamnesis::factory(),
        'heart_rate' => fake()->numberBetween(80, 130),
        'spo2' => fake()->numberBetween(90, 100),
        'status_anemia' => fake()->randomElement(['Anemia', 'Normal']) 
        ];
    }

}
