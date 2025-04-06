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
            'user_first_name'       => 'MDL',
            'user_last_name'        => 'Admin',
            'user_email'            => 'mdl@admin.com',
            'user_password'         => Hash::make('mdladmin'),
            'user_contact_no'       => '09222555100',
            'user_date_of_birth'    => '2003-04-19',
            'user_profile_image'    => null,
            'user_type'             => 'admin',
            'user_account_status'   => 'active'
        ]);
    }
}
