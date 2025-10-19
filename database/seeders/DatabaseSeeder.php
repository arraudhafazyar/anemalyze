<?php

namespace Database\Seeders;

use App\Models\Anamnesis;
use App\Models\Pasien;
use App\Models\Pemeriksaan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin1',
            'username' => 'iasksadn',
            'password' => 'jyacantik'
        ]);
        User::factory()->create([
            'name' => 'admin2',
            'username' => 'iadjyand',
            'password' => 'jyacantik'
        ]);

    $pasiens = Pasien::factory(5)->create();

    // Setiap pasien punya beberapa anamnesis
    foreach ($pasiens as $pasien) {
        $anamneses = Anamnesis::factory(3)->create([
            'pasien_id' => $pasien->id,
        ]);

        // Setiap anamnesis punya 1 pemeriksaan
        foreach ($anamneses as $anamnesis) {
            Pemeriksaan::factory()->create([
                'anamnesis_id' => $anamnesis->id,
                'pasien_id' => $pasien->id,
            ]);
        };
    }
    }
}
