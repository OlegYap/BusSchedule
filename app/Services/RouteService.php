<?php

namespace App\Services;

use App\DTO\RouteDTO;
use App\Models\Route;
use App\Models\Stop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RouteService
{
    private RouteDirectionService $routeDirectionService;

    public function __construct(RouteDirectionService $routeDirectionService)
    {
        $this->routeDirectionService = $routeDirectionService;
    }

    public function updateRoute(Route $route, RouteDTO $dto): ?Route
    {
        try {
            DB::beginTransaction();

            if ($dto->name !== null) {
                $route->update(['name' => $dto->name]);
            }

            $route->directions()->delete();

            foreach ($dto->directions as $directionDTO) {
                $name = $this->getDirectionName($directionDTO->direction, $directionDTO->stopIds);

                $this->routeDirectionService->createDirection(
                    $directionDTO,
                    $route->id,
                    $name
                );
            }

            DB::commit();
            return $route->fresh(['directions.routeStops.stop']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Ошибка при обновлении маршрута', ['exception' => $exception]);
            return null;
        }
    }

    private function getDirectionName($direction, array $stopIds): string
    {
        $lastStopId = end($stopIds);
        $lastStop = Stop::find($lastStopId);

        return $lastStop ? $lastStop->name : 'Неизвестная остановка';
    }
}
