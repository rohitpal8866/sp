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
            'phone' => '8866492880',
            'password' => Hash::make('Amjad@8866'),
        ]);
        
        User::create([
            'name' => 'Rohit Pal',
            'email'=> 'rohit@yopmail.com',
            'phone' => '7048865600',
            'password'=> Hash::make('Rohit@123'),
        ]);
        
        User::create([
            'name' => 'Priya Sharma',
            'email' => 'priya.sharma@example.com',
            'phone' => '9876543210',
            'password' => Hash::make('Priya@1234'),
        ]);
        
        User::create([
            'name' => 'Arvind Kumar',
            'email' => 'arvind.kumar@example.com',
            'phone' => '8800123456',
            'password' => Hash::make('Arvind@5678'),
        ]);
        
        User::create([
            'name' => 'Anjali Reddy',
            'email' => 'anjali.reddy@example.com',
            'phone' => '9034567890',
            'password' => Hash::make('Anjali@8901'),
        ]);
        
        User::create([
            'name' => 'Sandeep Singh',
            'email' => 'sandeep.singh@example.com',
            'phone' => '7045587745',
            'password' => Hash::make('Sandeep@1122'),
        ]);
        
        User::create([
            'name' => 'Neha Gupta',
            'email' => 'neha.gupta@example.com',
            'phone' => '9812345678',
            'password' => Hash::make('Neha@9876'),
        ]);
        
        User::create([
            'name' => 'Vijay Mehta',
            'email' => 'vijay.mehta@example.com',
            'phone' => '9998765432',
            'password' => Hash::make('Vijay@2345'),
        ]);
        
        User::create([
            'name' => 'Kavita Joshi',
            'email' => 'kavita.joshi@example.com',
            'phone' => '8856239145',
            'password' => Hash::make('Kavita@6789'),
        ]);
        
        User::create([
            'name' => 'Rajesh Patel',
            'email' => 'rajesh.patel@example.com',
            'phone' => '9945678921',
            'password' => Hash::make('Rajesh@2345'),
        ]);
        
        $this->call(BuildingSeeder::class);
        $this->call(FlatSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(BillSeeder::class);
    }
}
