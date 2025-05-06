<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegularSalary extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'salary_type_id',
        'employee_id',
        'monthly_rate'
    ];
}
