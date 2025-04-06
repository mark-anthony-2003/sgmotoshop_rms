<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parts')->insert([
            [
                'part_name'     => 'Engine Oil',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'part_name'     => 'Brake Pads',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'part_name'     => 'Spark Plug',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'part_name'     => 'Air Filter',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'part_name'     => 'Battery',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'part_name'     => 'Chain Set',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'part_name'     => 'Tire (Front)',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'part_name'     => 'Tire (Rear)',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'part_name'     => 'Clutch Cable',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
            [
                'part_name'     => 'Side Mirror Set',
                'created_at'    => now(),
                'updated_at'    => now()
            ],
        ]);
    }
}
