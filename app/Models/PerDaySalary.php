<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerDaySalary extends Model
{
    use HasFactory;

    protected $primaryKey = 'per_day_salary_id';

    protected $fillable = [
        'per_day_salary_salary_type_id',
        'per_day_salary_daily_rate',
        'per_day_salary_days_worked'
    ];
}
