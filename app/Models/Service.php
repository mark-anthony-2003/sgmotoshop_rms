<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';

    protected $fillable = [
        'total_amount',
        'preferred_date',
        'payment_method',
        'payment_reference',
        'payment_status',
    ];

    // Relationships
    public function serviceDetail(): BelongsTo
    {
        return $this->belongsTo(ServiceDetail::class, 'service_id');
    }
    public function serviceTransaction(): HasOne
    {
        return $this->hasOne(ServiceTransaction::class, 'service_id');
    }
    public function inventories(): MorphMany
    {
        return $this->morphMany(Inventory::class, 'inventory');
    }
}
