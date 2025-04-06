<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('salary_types')->insert([
            [
                'salary_type_name'  => 'regular',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
            [
                'salary_type_name'  => 'per_day',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
        ]);
    }
}
