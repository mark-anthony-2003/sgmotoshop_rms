<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PositionTypeSeeder::class,
            SalaryTypeSeeder::class,

            UserSeeder::class,
            AdminSeeder::class,
            EmployeeSeeder::class,

            ItemSeeder::class,
            ServiceTypeSeeder::class,
            PartSeeder::class,
        ]);
    }

}
