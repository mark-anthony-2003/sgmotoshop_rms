<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_detail_id';

    protected $fillable = [
        'service_detail_service_id',
        'service_detail_service_type_id',
        'service_detail_part_id'
    ];
}
