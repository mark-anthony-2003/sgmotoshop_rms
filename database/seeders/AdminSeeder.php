<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name'       => 'MDL',
            'last_name'        => 'Admin',
            'email'            => 'mdl@admin.com',
            'password'         => Hash::make('mdladmin'),
            'contact_number'   => '09222555100',
            'date_of_birth'    => '2003-04-19',
            'profile_image'    => null,
            'user_type'        => 'admin',
            'user_status'      => 'active'
        ]);
    }
}
