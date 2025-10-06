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
        ]);
        User::factory()->create([
            'name' => 'admin2',
            'username' => 'iadjyand',
        ]);

        Pemeriksaan::factory(10)->recycle([
            Pasien::factory(10)->recycle(
                Anamnesis::factory(10)->create())->create()]
        )->create();

    }
}   
