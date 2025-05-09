<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_detail_id';

    protected $fillable = [
        'service_id',
        'service_type_id',
        'part_id',
        'employee_id',
        'approval_type',
        'manager_remarks'
    ];

    // Relationships
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }
    public function laborer()
    {
        return $this->belongsTo(Laborer::class, 'employee_id', 'employee_id');
    }
}
