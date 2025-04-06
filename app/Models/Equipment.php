<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $primaryKey = 'equipment_id';

    protected $fillable = [
        'equipment_employee_id',
        'equipment_service_id',
        'equipment_name',
        'equipment_purchase_date',
        'equipment_maintenance_date',
        'equipment_status'
    ];
}
