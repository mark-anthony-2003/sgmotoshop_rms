<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'shipment_id', 'shipment_id');
    }
}
