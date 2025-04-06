<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';

    protected $fillable = [
        'service_total_amount',
        'service_payment_method',
        'service_payment_status',
        'service_payment_ref_no',
        'service_preferred_date'
    ];
}
