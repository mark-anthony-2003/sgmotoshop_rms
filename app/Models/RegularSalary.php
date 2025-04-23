<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegularSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_type_id',
        'monthly_rate'
    ];
}
