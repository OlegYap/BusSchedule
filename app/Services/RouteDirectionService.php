<?php

namespace App\Services;
use App\DTO\RouteDirectionDTO;
use App\Models\RouteDirection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RouteDirectionService
{
    public function createDirection(RouteDirectionDTO $dto, int $routeId, string $name): ?RouteDirection
    {
        try {
            DB::beginTransaction();

            $routeDirection = RouteDirection::create([
                'route_id' => $routeId,
                'direction' => $dto->direction,
                'name' => $name
            ]);

            $this->updateStops($routeDirection, $dto->stopIds);

            DB::commit();
            return $routeDirection->fresh(['routeStops.stop']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Ошибка при создании направления маршрута', ['exception' => $exception]);
            return null;
        }
    }

    public function updateDirection(RouteDirection $routeDirection, RouteDirectionDTO $dto): ?RouteDirection
    {
        try {
            DB::beginTransaction();

            // Обновляем направление
            $routeDirection->update([
                'direction' => $dto->direction
            ]);

            // Если переданы остановки, обновляем их
            if (!empty($dto->stopIds)) {
                // Удаляем старые остановки
                $routeDirection->routeStops()->delete();

                // Создаем новые остановки с правильным порядком
                $this->updateStops($routeDirection, $dto->stopIds);
            }

            DB::commit();
            return $routeDirection->fresh(['routeStops.stop']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Ошибка при обновлении направления маршрута', ['exception' => $exception]);
            return null;
        }
    }

    public function deleteDirection(RouteDirection $routeDirection): bool
    {
        try {
            DB::beginTransaction();
            $result = $routeDirection->delete();
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Ошибка при удалении направления маршрута', ['exception' => $exception]);
            return false;
        }
    }

    public function updateStops(RouteDirection $routeDirection, array $stopIds): void
    {
        $routeStops = [];

        foreach ($stopIds as $index => $stopId) {
            $routeStops[] = [
                'stop_id' => $stopId,
                'stop_order' => $index + 1
            ];
        }

        $routeDirection->routeStops()->createMany($routeStops);
    }

}
