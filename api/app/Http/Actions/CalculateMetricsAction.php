<?php

namespace App\Actions;

use App\Http\Actions\GetLatestMetricsAction;
use App\Models\ApiCallLog;
use App\Models\MetricSummary;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CalculateMetricsAction
{

    public static function execute(): ?MetricSummary
    {
        $period = self::getSamplingPeriod();
        if (!$period['start']) {
            return null;
        }

        $logQuery = self::getRelevantLogs($period['start'], $period['end']);
        if ($logQuery->doesntExist()) {
            return null;
        }

        $averageDuration = self::calculateAverageDuration($logQuery);
        $peakHour = self::calculatePeakHour($period['start'], $period['end']);

        return self::persistMetrics(
            averageDuration: $averageDuration,
            peakHour: $peakHour,
            samplingStart: $period['start'],
            samplingEnd: $period['end']
        );
    }


    private static function getSamplingPeriod(): array
    {
        $lastMetric = GetLatestMetricsAction::execute();

        $samplingStart = $lastMetric ?
            $lastMetric->sampling_end :
            ApiCallLog::query()->min('called_at');

        return [
            'start' => $samplingStart,
            'end' => Carbon::now(),
        ];
    }

    private static function getRelevantLogs(string $samplingStart, Carbon $samplingEnd): Builder
    {
        return ApiCallLog::query()
            ->where('called_at', '>', $samplingStart)
            ->where('called_at', '<=', $samplingEnd)
            ->where('resource_type', 'people');
    }

    private static function persistMetrics(float $averageDuration, ?int $peakHour, string $samplingStart, Carbon $samplingEnd): MetricSummary
    {
        return MetricSummary::query()
            ->create([
                'average_duration_ms' => (int) round($averageDuration),
                'peak_hour' => $peakHour,
                'sampling_start' => $samplingStart,
                'sampling_end' => $samplingEnd,
                'calculation_time' => now(),
            ]);
    }

    private static function calculateAverageDuration(Builder $query): float
    {
        return $query->avg('duration_ms') ?? 0.0;
    }

    private static function calculatePeakHour(string $samplingStart, Carbon $samplingEnd): ?int
    {
        return DB::table('api_call_logs')
            ->selectRaw('HOUR(called_at) as hour, COUNT(*) as total')
            ->where('called_at', '>', $samplingStart)
            ->where('called_at', '<=', $samplingEnd)
            ->where('resource_type', 'people')
            ->groupBy('hour')
            ->orderByDesc('total')
            ->value('hour');
    }
}
