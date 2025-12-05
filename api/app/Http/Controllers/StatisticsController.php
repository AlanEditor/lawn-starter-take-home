<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetricSummary;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function averageRequestTime(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Average request time (TODO: implementacao)']);
    }

    public function mostPopularHour(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Most popular hour (TODO: implementacao)']);
    }
}
