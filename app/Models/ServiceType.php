<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceType extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_type_id';

    protected $fillable = [
        'service_type_name',
        'service_type_price',
        'service_type_image',
        'service_type_status'
    ];

    // Relationships
    public function serviceDetail(): HasMany
    {
        return $this->hasMany(ServiceDetail::class, 'service_detail_id', 'service_type_id');
    }
}
