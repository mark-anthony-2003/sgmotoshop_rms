<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $primaryKey = 'manager_id';

    protected $fillable = [
        'manager_position_type_id',
        'manager_area_checker',
        'manager_inventory_recorder',
        'manager_payroll_assistance'
    ];
}
