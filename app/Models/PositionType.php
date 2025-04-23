<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionType extends Model
{
    use HasFactory;

    protected $primaryKey = 'position_type_id';

    protected $fillable = [
        'position_name'
    ];
}
