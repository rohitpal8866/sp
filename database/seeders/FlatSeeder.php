<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Flat;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = Building::all();
        $users = User::all();
        
        $max = rand(30, 60);
        $faker = Faker::create();
        
        for ($i = 0; $i < $max; $i++) {
            Flat::create([
                'name' => 'Flat ' . $faker->numberBetween(101, 999),
                'building_id' => $buildings->random()->id,
                'user_id' => $users->random()->id,
                'rent' => round($faker->randomFloat(2, 1500, 10000)),
            ]);
        }

        // Loop through each building and create flats for them
        // foreach ($buildings as $building) {
        //     // Create multiple flats for each building
        //     Flat::create([
        //         'name' => $flatNames[array_rand($flatNames)],
        //         'building_id' => $building->id,
        //         'user_id' => $users->random()->id,  // Randomly assign an existing user
        //         'rent' => 100,
        //     ]);
    
        //     Flat::create([
        //         'name' => $flatNames[array_rand($flatNames)],
        //         'building_id' => $building->id,
        //         'user_id' => $users->random()->id,  // Randomly assign an existing user
        //         'rent' => 120,
        //     ]);
    
        //     Flat::create([
        //         'name' => $flatNames[array_rand($flatNames)],
        //         'building_id' => $building->id,
        //         'user_id' => $users->random()->id,  // Randomly assign an existing user
        //         'rent' => 150,
        //     ]);
    
        //     Flat::create([
        //         'name' => $flatNames[array_rand($flatNames)],
        //         'building_id' => $building->id,
        //         'user_id' => $users->random()->id,  // Randomly assign an existing user
        //         'rent' => 180,
        //     ]);
    
        //     Flat::create([
        //         'name' => $flatNames[array_rand($flatNames)],
        //         'building_id' => $building->id,
        //         'user_id' => $users->random()->id,  // Randomly assign an existing user
        //         'rent' => 200,
        //     ]);
        // }
    }
    
}
