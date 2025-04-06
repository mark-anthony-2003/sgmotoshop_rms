<?php

namespace Database\Seeders;

use App\Models\Employee;
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

        $employeees = User::where('user_type', 'employee')->get();
        if ($employeees->isEmpty()) return;

        // Assign the first employee as a Manager
        $firstEmployee = $employeees->shift();
        Employee::updateOrCreate(
            ['employee_user_id' => $firstEmployee->user_id],
            [
                'employee_service_transaction_id'   => null,
                'employee_salary_type_id'           => $defaultSalary,
                'employee_position_type_id'         => $managerPosition,
                'employee_date_hired'               => now()
            ]
        );

        // Assign the rest as Laborers
        foreach ($employeees as $laborer)
        {
            Employee::updateOrCreate(
                ['employee_user_id' => $laborer->user_id],
                [
                    'employee_service_transaction_id'   => null,
                    'employee_salary_type_id'           => $defaultSalary,
                    'employee_position_type_id'         => $laborerPosition,
                    'employee_date_hired'               => now()
                ]
            );
        }
    }
}
