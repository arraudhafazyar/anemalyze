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

        // User::factory(10)->create();

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


    // Pasien::factory(10)
    //     ->has(Anamnesis::factory()->count(2))
    //     ->has(Pemeriksaan::factory()->count(3))
    //     ->create();
    //     }

    Pasien::factory(10)
            ->has(Anamnesis::factory()->count(rand(1, 3)))
            ->has(Pemeriksaan::factory()->count(rand(1, 3)))
            ->create();
    }
}
