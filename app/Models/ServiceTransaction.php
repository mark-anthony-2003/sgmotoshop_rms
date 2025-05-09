<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_transaction_id';

    protected $fillable = [
        'user_id',
        'service_id',
    ];

    protected static function booted()
    {
        static::created(function ($service_transaction) {
            Inventory::firstOrCreate(
                ['service_transaction_id' => $service_transaction->service_transaction_id],
                [
                    'item_id' => null,
                    'employee_id' => null,
                    'equipment_id' => null,
                    'finance_id' => null,
                    'sales' => 0
                ]
            );
        });
    }
    
}
