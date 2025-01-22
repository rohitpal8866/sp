<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $max = rand(10,15);

        $faker = Faker::create();
        for ($i = 0; $i < $max; $i++){
            User::create([
            'name' => $faker->name(),
            'email' => $faker->email(),
            'phone' => preg_replace('/\D/', '', $faker->phoneNumber()),
            'password' => Hash::make('Admin@123'),
        ]);
        }
    }
}
