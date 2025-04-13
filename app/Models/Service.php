<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    // Relationships
    public function serviceDetail(): BelongsTo
    {
        return $this->belongsTo(ServiceDetail::class);
    }
    public function serviceTransaction(): HasOne
    {
        return $this->hasOne(ServiceTransaction::class, 'service_traction_service_id', 'service_id');
    }
}
