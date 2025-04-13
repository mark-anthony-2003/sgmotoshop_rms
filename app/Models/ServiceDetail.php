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
        'service_detail_service_id',
        'service_detail_service_type_id',
        'service_detail_part_id',
        'st_assignment_by_manager',
        'st_approval_type',
        'st_manager_remarks'
    ];

    // Relationships
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_detail_service_id', 'service_id');
    }
    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, 'service_detail_service_type_id', 'service_type_id');
    }
    public function assignedByManager(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'st_assigned_by_manager_id', 'manager_id');
    }
    
}
