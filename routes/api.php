<?php

use App\Http\Controllers\API\RouteController;
use App\Http\Controllers\API\RouteDirectionController;
use App\Http\Controllers\API\StopController;
use App\Http\Controllers\API\BusController;
use Illuminate\Support\Facades\Route;

Route::get('/find-bus', [BusController::class, 'findBus']);


// Управление маршрутами
Route::apiResource('routes', RouteController::class);

// Управление направлениями маршрутов
Route::apiResource('route-directions', RouteDirectionController::class);

// Управление остановками
Route::apiResource('stops', StopController::class);
