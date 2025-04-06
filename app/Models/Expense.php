<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $primaryKey = 'expense_id';

    protected $fillable = [
        'expense_finance_id',
        'expense_type',
        'expense_amount'
    ];
}
