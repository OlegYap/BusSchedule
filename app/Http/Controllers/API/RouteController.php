<?php

namespace App\Http\Controllers\API;

use App\DTO\RouteDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Http\Resources\RouteResource;
use App\Models\Route;
use App\Services\RouteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RouteController extends Controller
{
    private RouteService $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }


    public function index(): AnonymousResourceCollection
    {
        $routes = Route::with(['directions.routeStops.stop'])->get();
        return RouteResource::collection($routes);
    }


    public function show(Route $route): RouteResource
    {
        $route->load(['directions.routeStops.stop']);
        return new RouteResource($route);
    }


    public function store(StoreRouteRequest $request): JsonResponse
    {
        $dto = RouteDTO::fromRequestData(
            $request->input('name'),
            $request->input('directions')
        );

        $route = Route::create(['name' => $dto->name]);
        $result = $this->routeService->updateRoute($route, $dto);

        if ($result === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ошибка при создании маршрута'],
                500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Маршрут успешно создан',
            'route' => new RouteResource($result)
        ], 201);
    }


    public function update(UpdateRouteRequest $request, Route $route): JsonResponse
    {
        $directions = $request->input('directions', []);
        if ($directions === null) {
            $directions = [];
        }

        $dto = RouteDTO::fromRequestData(
            $request->input('name'),
            $directions
        );

        $result = $this->routeService->updateRoute($route, $dto);

        if ($result === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ошибка при обновлении маршрута'],
                500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Маршрут успешно обновлен',
            'route' => new RouteResource($result)
        ]);
    }


    public function destroy(Route $route): JsonResponse
    {
        $result = $route->delete();

        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ошибка при удалении маршрута'
            ], 500);
        }

        return response()->json(null, 204);
    }
}
