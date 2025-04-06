<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManagerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managers = Employee::where('employee_position_type_id', 1)->get();
        foreach ($managers as $manager)
        {
            Manager::updateOrCreate(
                [
                    'manager_position_type_id' => $manager->employee_position_type_id
                ]
            );
        }
    }
}
