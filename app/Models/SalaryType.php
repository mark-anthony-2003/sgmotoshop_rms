<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryType extends Model
{
    use HasFactory;

    protected $primaryKey = 'salary_type_id';

    protected $fillable = [
        'salary_type_name'
    ];
}
