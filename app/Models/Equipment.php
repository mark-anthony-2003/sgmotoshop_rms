<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $primaryKey = 'equipment_id';

    protected $fillable = [
        'employee_id',
        'service_id',
        'equipment_name',
        'purchase_date',
        'maintenance_date',
        'equipment_status'
    ];
}
