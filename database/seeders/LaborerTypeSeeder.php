<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Laborer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaborerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workerRoles = [
            'Mechanic',                 // General vehicle repairs and maintenance
            'Auto Electrician',         // Electrical wiring and diagnostics
            'Transmission Specialist',  // CVT Cleaning & Transmission repairs
            'Welder',                   // Welding services
            'Tire Technician',          // Vulcanizing and tire-related work
            'Oil Change Specialist'     // Oil change and fluid checks
        ];

        $laborers = Employee::where('employee_position_type_id', 2)->get();
        foreach ($laborers as $laborer)
        {
            // Assign a worker role randomly
            $assignedWorkerRole = $workerRoles[array_rand($workerRoles)];
            Laborer::updateOrCreate(
                [
                    'laborer_position_type_id'  => $laborer->employee_position_type_id,
                    'laborer_work'              => $assignedWorkerRole
                ]
            );
        }
    }
}
