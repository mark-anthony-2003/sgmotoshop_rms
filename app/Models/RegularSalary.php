<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegularSalary extends Model
{
    use HasFactory;

    protected $primaryKey = 'regular_salary_id';

    protected $fillable = [
        'regular_salary_salary_type_id',
        'regular_salary_monthly_rate'
    ];
}
