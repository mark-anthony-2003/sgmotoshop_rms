<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'user_id',
        'service_transaction_id',
        'salary_type_id',
        'position_type_id',
        'date_hired'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function positionType(): BelongsTo
    {
        return $this->belongsTo(PositionType::class, 'position_type_id');
    }

    public function salaryType(): BelongsTo
    {
        return $this->belongsTo(SalaryType::class, 'salary_type_id');
    }
}
