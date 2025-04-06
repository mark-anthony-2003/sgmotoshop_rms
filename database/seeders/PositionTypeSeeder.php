<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('position_types')->insert([
            [
                'position_type_name'    => 'manager',
                'created_at'            => now(),
                'updated_at'            => now()
            ],
            [
                'position_type_name'    => 'laborer',
                'created_at'            => now(),
                'updated_at'            => now()
            ]
        ]);
    }
}
