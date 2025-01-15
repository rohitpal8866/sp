<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Flat;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all the buildings
        $buildings = Building::all();
    
        // Get all the users
        $users = User::all();
    
        $flatNames = [
            'A Wing', 'B Wing', 'C Wing', 'D Wing', 'E Wing', 
            '1st Floor', '2nd Floor', 'Penthouse', 'Garden View', 'Sky View'
        ];

        // Loop through each building and create flats for them
        foreach ($buildings as $building) {
            // Create multiple flats for each building
            Flat::create([
                'name' => $flatNames[array_rand($flatNames)],
                'building_id' => $building->id,
                'user_id' => $users->random()->id,  // Randomly assign an existing user
                'rent' => 100,
            ]);
    
            Flat::create([
                'name' => $flatNames[array_rand($flatNames)],
                'building_id' => $building->id,
                'user_id' => $users->random()->id,  // Randomly assign an existing user
                'rent' => 120,
            ]);
    
            Flat::create([
                'name' => $flatNames[array_rand($flatNames)],
                'building_id' => $building->id,
                'user_id' => $users->random()->id,  // Randomly assign an existing user
                'rent' => 150,
            ]);
    
            Flat::create([
                'name' => $flatNames[array_rand($flatNames)],
                'building_id' => $building->id,
                'user_id' => $users->random()->id,  // Randomly assign an existing user
                'rent' => 180,
            ]);
    
            Flat::create([
                'name' => $flatNames[array_rand($flatNames)],
                'building_id' => $building->id,
                'user_id' => $users->random()->id,  // Randomly assign an existing user
                'rent' => 200,
            ]);
        }
    }
    
}
