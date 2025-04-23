<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'finance_id',
        'product_id',
        'service_id',
        'expense_type',
        'amount'
    ];
}
