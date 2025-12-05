<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ApiCallLog extends Model
{
    protected $fillable = [
        'resource_type',
        'duration_ms',
        'called_at',
        'request_data',
    ];

    protected $casts = [
        'request_data' => 'array',
        'called_at' => 'datetime',
    ];
}
