<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerDaySalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_type_id',
        'daily_rate',
        'days_worked'
    ];
}
