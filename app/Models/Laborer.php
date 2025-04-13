<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laborer extends Model
{
    use HasFactory;

    protected $primaryKey = 'laborer_id';

    protected $fillable = [
        'laborer_employee_id',
        'laborer_position_type_id',
        'laborer_work',
        'laborer_employment_status'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'laborer_employee_id', 'employee_id');
    }
}
