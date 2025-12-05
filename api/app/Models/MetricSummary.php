<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetricSummary extends Model
{
    protected $fillable = [
        'average_duration_ms',
        'peak_hour',
        'sampling_start',
        'sampling_end',
        'calculation_time',
    ];

    protected $casts = [
        'sampling_start' => 'datetime',
        'sampling_end' => 'datetime',
        'calculation_time' => 'datetime',
        'average_duration_ms' => 'integer',
        'peak_hour' => 'integer',
    ];
}
