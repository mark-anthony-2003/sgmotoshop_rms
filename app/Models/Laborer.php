<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laborer extends Model
{
    use HasFactory;

    protected $primaryKey = 'laborer_id';

    protected $fillable = [
        'laborer_position_type_id',
        'laborer_work',
        'laborer_employment_status'
    ];
}
