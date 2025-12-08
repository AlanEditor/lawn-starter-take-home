<?php

namespace App\Http\Controllers;

use App\Http\Actions\ProcessSwapiCallAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SwapiProxyController extends Controller
{
    public function proxy(Request $request, string $resource, ?string $identifier = null): JsonResponse
    {
        $response = ProcessSwapiCallAction::execute($resource, $identifier, $request);

        return response()->json(
            $response->json(),
            $response->status()
        );
    }
}
