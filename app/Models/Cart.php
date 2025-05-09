<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id',
        'item_id',
        'shipment_id',
        'quantity',
        'sub_total'
    ];

    // Relationships
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class, 'cart_id', 'cart_id');
    }
}
