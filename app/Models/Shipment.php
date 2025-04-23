<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $primaryKey = 'shipment_id';

    protected $fillable = [
        'cart_id',
        'total_amount',
        'item_status',
        'shipment_date',
        'shipment_method',
        'payment_method',
        'payment_status',
        'payment_reference'
    ];
}
