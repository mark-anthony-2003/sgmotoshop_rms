<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 employees
        User::factory()->count(5)->employee()->create();
        // Create 5 customer
        User::factory()->count(5)->customer()->create();
    }
}
