<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $max = rand(5, 20);
        for ($i = 0; $i < $max; $i++) {
            Building::create([
                'name' => $faker->company(),
            ]);
        }
    }
    
}
