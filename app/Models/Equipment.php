<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $primaryKey = 'equipment_id';

    protected $fillable = [
        'employee_id',
        'service_id',
        'equipment_name',
        'purchase_date',
        'maintenance_date',
        'equipment_status'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, 'service_id', 'service_type_id');
    }
}
