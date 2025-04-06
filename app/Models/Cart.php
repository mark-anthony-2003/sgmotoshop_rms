<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
