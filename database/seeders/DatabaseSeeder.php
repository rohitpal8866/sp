<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Amjad Shah',
            'email' => 'nexfed06@gmail.com',
            'password'=> Hash::make('Amjad@8866'),
        ]);

        $this->call(BuildingSeeder::class);
    }
}
