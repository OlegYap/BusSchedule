<?php

namespace Database\Factories;

use App\Models\RouteStop;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hour = $this->faker->numberBetween(6, 22);
        $minute = $this->faker->randomElement([0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55]);

        return [
            'route_stop_id' => RouteStop::factory(),
            'arrival_time' => sprintf('%02d:%02d:00', $hour, $minute),
        ];
    }
}
