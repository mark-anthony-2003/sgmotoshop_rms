<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $primaryKey = 'inventory_id';

    protected $fillable = [
        'inventory_product_id',
        'inventory_service_id',
        'inventory_employee_id',
        'inventory_equipment_id',
        'inventory_finance_id',
        'inventory_sales'
    ];
}
