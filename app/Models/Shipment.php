<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $primaryKey = 'shipment_id';

    protected $fillable = [
        'shipment_cart_id',
        'shipment_total_amount',
        'shipment_item_status',
        'shipment_method',
        'shipment_date',
        'shipment_payment_method',
        'shipment_payment_status',
        'shipment_payment_ref'
    ];
}
