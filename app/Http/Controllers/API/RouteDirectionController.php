<?php

namespace App\Http\Controllers\API;

use App\DTO\RouteDirectionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRouteDirectionRequest;
use App\Http\Requests\UpdateRouteDirectionRequest;
use App\Http\Resources\RouteDirectionResource;
use App\Models\RouteDirection;
use App\Services\RouteDirectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RouteDirectionController extends Controller
{
    private RouteDirectionService $routeDirectionService;

    public function __construct(RouteDirectionService $routeDirectionService)
    {
        $this->routeDirectionService = $routeDirectionService;
    }

    public function index(): AnonymousResourceCollection
    {
        $directions = RouteDirection::with(['routeStops.stop'])->get();
        return RouteDirectionResource::collection($directions);
    }

    public function show(RouteDirection $routeDirection): RouteDirectionResource
    {
        $routeDirection->load(['routeStops.stop']);
        return new RouteDirectionResource($routeDirection);
    }

    public function store(StoreRouteDirectionRequest $request): JsonResponse
    {
        $dto = RouteDirectionDTO::fromRequestData(
            $request->input('direction'),
            $request->input('stops')
        );

        $routeId = $request->input('route_id');
        $name = $request->input('name');

        $result = $this->routeDirectionService->createDirection($dto, $routeId, $name);

        if ($result === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ошибка при создании направления маршрута'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Направление маршрута успешно создано',
            'direction' => new RouteDirectionResource($result)
        ], 201);
    }

    public function update(UpdateRouteDirectionRequest $request, RouteDirection $routeDirection): JsonResponse
    {
        $dto = RouteDirectionDTO::fromRequestData(
            $request->input('direction', $routeDirection->direction->value),
            $request->input('stops', [])
        );

        $name = $request->input('name', $routeDirection->name);
        $result = $this->routeDirectionService->updateDirection($routeDirection, $dto, $name);

        if ($result === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ошибка при обновлении направления маршрута'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Направление маршрута успешно обновлено',
            'direction' => new RouteDirectionResource($result)
        ]);
    }

    public function destroy(RouteDirection $routeDirection): JsonResponse
    {
        $result = $this->routeDirectionService->deleteDirection($routeDirection);

        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ошибка при удалении направления маршрута'
            ], 500);
        }

        return response()->json(null, 204);
    }
}
