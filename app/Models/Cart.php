<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'cart_user_id',
        'cart_item_id',
        'cart_quantity',
        'cart_sub_total'
    ];

    // Relationships
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'cart_item_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cart_user_id');
    }
}
