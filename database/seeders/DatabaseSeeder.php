<?php

namespace Database\Seeders;

use App\Enums\DirectionType;
use App\Models\Route;
use App\Models\RouteDirection;
use App\Models\RouteStop;
use App\Models\Schedule;
use App\Models\Stop;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $stops = Stop::factory(20)->create();
        $this->command->info('Создано 20 остановок');

        Route::factory(5)->create()->each(function ($route) use ($stops) {
            $this->command->info("Создание маршрута №{$route->name}");
            $directions = [
                RouteDirection::factory()->create([
                    'route_id' => $route->id,
                    'direction' => DirectionType::FORWARD->value,
                    'name' => $stops->random()->name,
                ]),
                RouteDirection::factory()->create([
                    'route_id' => $route->id,
                    'direction' => DirectionType::BACKWARD->value,
                    'name' => $stops->random()->name,
                ])
            ];

            foreach ($directions as $direction) {
                $randomStops = $stops->random(rand(5, min(10, $stops->count())));

                foreach ($randomStops as $index => $stop) {
                    $routeStop = RouteStop::create([
                        'route_direction_id' => $direction->id,
                        'stop_id' => $stop->id,
                        'stop_order' => $index + 1,
                    ]);

                    for ($i = 0; $i < 10; $i++) {
                        $hour = rand(6, 23);
                        $minute = rand(0, 59);

                        Schedule::create([
                            'route_stop_id' => $routeStop->id,
                            'arrival_time' => sprintf('%02d:%02d:00', $hour, $minute),
                        ]);
                    }
                }
            }
        });
        $this->command->info('Заполнение базы данных завершено успешно!');
    }
}
