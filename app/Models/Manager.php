<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manager extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'position_type_id',
        'employee_id',
        'area_checker',
        'inventory_recorder',
        'payroll_assistance'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
