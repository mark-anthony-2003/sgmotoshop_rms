<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_type_id',
        'employee_id',
        'area_checker',
        'inventory_recorder',
        'payroll_assistance'
    ];
}
