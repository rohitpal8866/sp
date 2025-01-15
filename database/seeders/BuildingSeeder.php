<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Building::create([
            'name' => 'Shahajahan Palace',
        ]);
    
        Building::create([
            'name' => 'Red Fort',
        ]);
    
        Building::create([
            'name' => 'Taj Mahal',
        ]);
    
        Building::create([
            'name' => 'Qutub Minar',
        ]);
    
        Building::create([
            'name' => 'India Gate',
        ]);
    }
    
}
