<?php

use App\Jobs\CalculateMetricsJob;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new CalculateMetricsJob())
    ->everyFiveMinutes();

