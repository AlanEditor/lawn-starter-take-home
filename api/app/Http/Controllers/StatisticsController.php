<?php

namespace App\Http\Controllers;


use App\Http\Actions\GetLatestMetricsAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function averageRequestTime(Request $request): JsonResponse
    {
        $latestMetric = GetLatestMetricsAction::execute();

        if (!$latestMetric) {
            return response()->json([
                'average_duration_ms' => 0,
                'status' => 'No data calculated yet.',
            ], 200);
        }

        return response()->json([
            'average_duration_ms' => (int) $latestMetric->average_duration_ms,
            'sampled_from' => $latestMetric->sampling_start,
            'sampled_to' => $latestMetric->sampling_end,
        ]);
    }

    public function mostPopularHour(Request $request): JsonResponse
    {
        $latestMetric = GetLatestMetricsAction::execute();

        if (!$latestMetric) {
            return response()->json([
                'peak_hour' => null,
                'status' => 'No data calculated yet.',
            ], 200);
        }

        return response()->json([
            'peak_hour' => (int) $latestMetric->peak_hour,
            'sampled_from' => $latestMetric->sampling_start,
            'sampled_to' => $latestMetric->sampling_end,
        ]);
    }
}
