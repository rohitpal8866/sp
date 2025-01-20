<?php

namespace Database\Seeders;

use App\Models\Flat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flats = Flat::all();
        $faker = Faker::create(); // Initialize Faker to generate random data

        foreach ($flats as $flat) {
            $flat->bills()->create([
                'flat_id' => $flat->id,
                'rent' => $faker->randomFloat(2, 100, 1000), // Random rent between 100 and 1000
                'maintenance' => $faker->randomFloat(2, 50, 500), // Random maintenance charge between 50 and 500
                'light_bill' => $faker->randomFloat(2, 20, 300), // Random light bill between 20 and 300
                'bill_date' => $faker->date(), // Random date for the bill
                'paid' => $faker->boolean(70), // 70% chance that the bill is paid (true or false)
                'notes' => $faker->text(100), // Random notes with a max length of 100 characters
            ]);
        }
    }
}
