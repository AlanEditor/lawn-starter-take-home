<?php

namespace App\Http\Controllers;

use App\Models\ApiCallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class SwapiProxyController extends Controller
{
    private const SWAPI_BASE_URL = 'https://swapi.dev/api/';

    public function proxy(Request $request, string $resource, ?string $identifier = null): JsonResponse
    {
        return response()->json(['message' => 'SWAPI proxy working, log saved (TODO: implementação)']);
    }
}
