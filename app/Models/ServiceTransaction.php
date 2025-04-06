<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_transaction_id';

    protected $fillable = [
        'service_transaction_user_id',
        'service_transaction_service_id',
        'service_transaction_employee_id'
    ];
}
