<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'user_id',
        'service_transaction_id',
        'salary_type_id',
        'position_type_id',
        'employment_status',
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
    public function manager()
    {
        return $this->hasOne(Manager::class, 'employee_id');
    }
    public function laborer()
    {
        return $this->hasOne(Laborer::class, 'employee_id');
    }

    public function salaryType(): BelongsTo
    {
        return $this->belongsTo(SalaryType::class, 'salary_type_id');
    }
    public function regularSalary(): BelongsTo
    {
        return $this->belongsTo(RegularSalary::class, 'employee_id', 'employee_id');
    }
    public function perDaySalary(): HasOne
    {
        return $this->hasOne(PerDaySalary::class, 'employee_id', 'employee_id');
    }


    public function equipment(): HasOne
    {
        return $this->hasOne(Equipment::class, 'employee_id');
    }
}
