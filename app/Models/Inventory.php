<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $primaryKey = 'inventory_id';

    protected $fillable = [
        'item_id',
        'service_transaction_id',
        'employee_id',
        'equipment_id',
        'finance_id',
        'sales'
    ];
}
