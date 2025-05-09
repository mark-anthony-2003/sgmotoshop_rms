<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'finance_id',
        'employee_id',
        'basic_salary'
    ];
}
