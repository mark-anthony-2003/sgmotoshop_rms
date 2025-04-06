<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $primaryKey = 'salary_id';
    
    protected $fillable = [
        'salary_finance_id',
        'salary_employee_id',
        'salary_basic_salary'
    ];
}
