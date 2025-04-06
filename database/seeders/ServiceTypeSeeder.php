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
                'service_type_name'     => 'Overhauling',
                'service_type_price'    => 1500,
                'service_type_image'    => null,
                'service_type_status'   => 'available',
                'created_at'            => now(),
                'updated_at'            => now()
            ],
            [
                'service_type_name'     => 'Electrical Wiring',
                'service_type_price'    => 450,
                'service_type_image'    => null,
                'service_type_status'   => 'available',
                'created_at'            => now(),
                'updated_at'            => now()
            ],
            [
                'service_type_name'     => 'CVT Cleaning',
                'service_type_price'    => 350,
                'service_type_image'    => null,
                'service_type_status'   => 'available',
                'created_at'            => now(),
                'updated_at'            => now()
            ],
            [
                'service_type_name'     => 'Tune Up',
                'service_type_price'    => 200,
                'service_type_image'    => null,
                'service_type_status'   => 'available',
                'created_at'            => now(),
                'updated_at'            => now()
            ],
            [
                'service_type_name'     => 'Welding',
                'service_type_price'    => 0,
                'service_type_image'    => null,
                'service_type_status'   => 'available',
                'created_at'            => now(),
                'updated_at'            => now()
            ],
            [
                'service_type_name'     => 'Vulcanizing',
                'service_type_price'    => 50,
                'service_type_image'    => null,
                'service_type_status'   => 'available',
                'created_at'            => now(),
                'updated_at'            => now()
            ],
            [
                'service_type_name'     => 'Change Oil',
                'service_type_price'    => 30,
                'service_type_image'    => null,
                'service_type_status'   => 'available',
                'created_at'            => now(),
                'updated_at'            => now()
            ],
        ]);
    }
}
