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
        'employee_user_id',
        'employee_service_transaction_id',
        'employee_salary_type_id',
        'employee_position_type_id',
        'employee_date_hired'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_user_id', 'user_id');
    }

    public function positionType(): BelongsTo
    {
        return $this->belongsTo(PositionType::class, 'employee_position_type_id', 'position_type_id');
    }

    public function salaryType(): BelongsTo
    {
        return $this->belongsTo(SalaryType::class, 'employee_salary_type_id', 'salary_type_id');
    }
}
