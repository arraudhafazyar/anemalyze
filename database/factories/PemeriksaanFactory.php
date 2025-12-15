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
        'anamnesis_id' => Anamnesis::inRandomOrder()->first()->id ?? Anamnesis::factory(),
        'pasien_id' => Anamnesis::inRandomOrder()->first()->pasien_id ?? Pasien::factory(),
        'heart_rate' => fake()->numberBetween(80, 130),
        'spo2' => fake()->numberBetween(90, 100),
        'status_anemia' => fake()->randomElement(['Anemia', 'Normal']),
        'confidence' => fake()->randomFloat(2, 0, 100),
        'image_path' => 'images/' . fake()->uuid() . '.jpg',
        ];
    }

}
