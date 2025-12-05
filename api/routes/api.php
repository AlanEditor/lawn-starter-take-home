<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwapiProxyController;
use App\Http\Controllers\StatisticsController;

Route::get('/swapi/{resource}/{identifier?}', [SwapiProxyController::class, 'proxy'])
    ->where([
        'resource' => '[A-Za-z-]+',
        'identifier' => '.*',
    ]);

Route::controller(StatisticsController::class)->group(function () {
    Route::get('/stats/average-request-time', 'averageRequestTime');
    Route::get('/stats/most-popular-hour', 'mostPopularHour');
});
