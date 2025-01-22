<?php

namespace Database\Seeders;

use App\Models\Flat;
use Carbon\Carbon;
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
                'rent' => $flat->rent, // Random rent between 100 and 1000
                'maintenance' => round($faker->randomFloat(2, 50, 1000)), // Random maintenance charge between 50 and 500
                'light_bill' => round($faker->randomFloat(2, 500, 2000)), // Random light bill between 20 and 300
                'other' => round($faker->randomFloat(2, 5000, 10000)), // Random other charges between 20 and 300
                'bill_date' => Carbon::today()->subDays(rand(0, 1825)), // Random date for the bill
                'paid' => $faker->boolean(70), // 70% chance that the bill is paid (true or false)
                'notes' => $faker->text(100), // Random notes with a max length of 100 characters
            ]);
        }
    }
}
