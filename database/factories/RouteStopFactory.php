<?php

namespace Database\Factories;

use App\Models\RouteDirection;
use App\Models\RouteStop;
use App\Models\Stop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RouteStop>
 */
class RouteStopFactory extends Factory
{
    protected $model = RouteStop::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'route_direction_id' => RouteDirection::factory(),
            'stop_id' => Stop::factory(),
            'stop_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
