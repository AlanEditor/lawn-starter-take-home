<?php

namespace App\Http\Actions;

use App\Models\ApiCallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use InvalidArgumentException;

class ProcessSwapiCallAction
{
    private const string SWAPI_BASE_URL = 'https://swapi.dev/api/';

    private static function mapResource(string $resource): string
    {
        return match ($resource) {
            'people' => 'people',
            'planets' => 'planets',
            'starships' => 'starships',
            'vehicles' => 'vehicles',
            'movies' => 'films',
            'species' => 'species',
            default => throw new InvalidArgumentException("Invalid SWAPI resource: $resource"),
        };
    }

    public static function execute(string $resource, ?string $identifier, Request $request): Response
    {
        try {
            $swapiResource = self::mapResource($resource);
        } catch (InvalidArgumentException $e) {
            return new Response(new \GuzzleHttp\Psr7\Response(404, [], json_encode([
                'message' => $e->getMessage(),
            ])));
        }

        $swapiUrl = self::SWAPI_BASE_URL . $swapiResource . ($identifier ? "/{$identifier}" : '/');

        if ($request->getQueryString()) {
            $swapiUrl .= '?' . $request->getQueryString();
        }

        $startTime = microtime(true);
        $calledAt = Carbon::now();

        try {
            $response = Http::get($swapiUrl);

            $endTime = microtime(true);
            $durationMs = (int) round(($endTime - $startTime) * 1000);

            if (in_array($swapiResource, ['people', 'films'])) {
                ApiCallLog::query()
                    ->create([
                        'resource_type' => $swapiResource,
                        'duration_ms' => $durationMs,
                        'called_at' => $calledAt,
                        'request_data' => $request->all(),
                    ]);
            }

            return $response;

        } catch (\Exception $e) {
            return new Response(new \GuzzleHttp\Psr7\Response(503, [], json_encode([
                'message' => 'Error contacting SWAPI.',
                'error' => $e->getMessage()
            ])));
        }
    }
}
