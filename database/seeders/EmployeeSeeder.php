<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Laborer;
use App\Models\Manager;
use App\Models\PositionType;
use App\Models\SalaryType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSalary = SalaryType::where('salary_type_name', 'per_day')->value('salary_type_id');
        $laborerPosition = PositionType::where('position_type_name', 'laborer')->value('position_type_id');
        $managerPosition = PositionType::where('position_type_name', 'manager')->value('position_type_id');
        $workerRoles = [
            'Mechanic',                 // General vehicle repairs and maintenance
            'Auto Electrician',         // Electrical wiring and diagnostics
            'Transmission Specialist',  // CVT Cleaning & Transmission repairs
            'Welder',                   // Welding services
            'Tire Technician',          // Vulcanizing and tire-related work
            'Oil Change Specialist'     // Oil change and fluid checks
        ];

        $employeees = User::where('user_type', 'employee')->get();
        if ($employeees->isEmpty()) return;

        // Assign the first employee as a Manager
        $firstEmployee = $employeees->shift();
        $managerEmployee = Employee::updateOrCreate(
            ['employee_user_id' => $firstEmployee->user_id],
            [
                'employee_salary_type_id'           => $defaultSalary,
                'employee_position_type_id'         => $managerPosition,
                'employee_date_hired'               => now()
            ]
        );

        Manager::updateOrCreate(
            ['manager_employee_id' => $managerEmployee->employee_id],
            [
                'manager_position_type_id'      => $managerPosition,
                'manager_area_checker'          => true,
                'manager_inventory_recorder'    => true,
                'manager_payroll_assistance'    => true
            ]
        );

        // Assign the rest as Laborers
        foreach ($employeees as $laborer)
        {
            $laborerEmployee = Employee::updateOrCreate(
                ['employee_user_id' => $laborer->user_id],
                [
                    'employee_salary_type_id'           => $defaultSalary,
                    'employee_position_type_id'         => $laborerPosition,
                    'employee_date_hired'               => now()
                ]
            );

            $assignedWorkerRole = $workerRoles[array_rand($workerRoles)];
            Laborer::updateOrCreate(
                ['laborer_employee_id' => $laborerEmployee->employee_id],
                [
                    'laborer_position_type_id'  => $laborerPosition,
                    'laborer_work'              => $assignedWorkerRole,
                    'laborer_employment_status' => 'active'        
                ]
            );
        }
    }
}
