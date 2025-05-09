<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id';

    protected $fillable = [
        'item_name',
        'price',
        'stocks',
        'sold',
        'image',
        'item_status'
    ];

    protected static function booted()
    {
        static::created(function ($item) {
            Inventory::firstOrCreate(
                ['item_id' => $item->item_id],
                [
                    'service_transaction_id' => null,
                    'employee_id' => null,
                    'equipment_id' => null,
                    'finance_id' => null,
                    'sales' => 0
                ]
            );
        });
    }
}
