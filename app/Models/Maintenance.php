<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $primaryKey = 'maintenance_id';

    protected $fillable = [
        'maintenance_finance_id',
        'maintenance_equipment_id',
        'maintenance_type'
    ];
}
