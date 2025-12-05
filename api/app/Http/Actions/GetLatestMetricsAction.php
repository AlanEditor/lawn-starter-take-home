<?php

namespace App\Http\Actions;

use App\Models\MetricSummary;

class GetLatestMetricsAction
{
    public static function execute(): ?MetricSummary
    {
        return MetricSummary::query()
            ->latest('sampling_end')
            ->first();
    }
}
