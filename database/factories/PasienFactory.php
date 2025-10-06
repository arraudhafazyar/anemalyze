<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prefixes = ['081', '085', '089'];
        $prefix = fake()->randomElement($prefixes);
        return [
        'name' => $name = fake()->name(),
        // 'jenis_kelamin' =>fake()->randomElement(['Laki-laki', 'Perempuan']),
        'tempat_lahir' => fake()->city(),
        'tanggal_lahir' =>fake() ->date(),
        'phone_number' => $prefix . fake()->numerify('########'),
        'slug' => Str::slug($name, '-'),
        ];
    }
}
