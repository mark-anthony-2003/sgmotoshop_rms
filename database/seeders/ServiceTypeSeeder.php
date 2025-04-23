<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('service_types')->insert([
            [
                'service_name'      => 'Overhauling',
                'price'             => 1500,
                'image'             => null,
                'service_status'    => 'available',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
            [
                'service_name'      => 'Electrical Wiring',
                'price'             => 450,
                'image'             => null,
                'service_status'    => 'available',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
            [
                'service_name'      => 'CVT Cleaning',
                'price'             => 350,
                'image'             => null,
                'service_status'    => 'available',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
            [
                'service_name'      => 'Tune Up',
                'price'             => 200,
                'image'             => null,
                'service_status'    => 'available',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
            [
                'service_name'      => 'Welding',
                'price'             => 0,
                'image'             => null,
                'service_status'    => 'available',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
            [
                'service_name'      => 'Vulcanizing',
                'price'             => 50,
                'image'             => null,
                'service_status'    => 'available',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
            [
                'service_name'      => 'Change Oil',
                'price'             => 30,
                'image'             => null,
                'service_status'    => 'available',
                'created_at'        => now(),
                'updated_at'        => now()
            ],
        ]);
    }
}
