<?php

namespace Database\Factories;

use App\Enums\DirectionType;
use App\Models\Route;
use App\Models\RouteDirection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RouteDirection>
 */
class RouteDirectionFactory extends Factory
{
    protected $model = RouteDirection::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'route_id' => Route::factory(),
            'direction' => $this->faker->randomElement([
                DirectionType::FORWARD->value,
                DirectionType::BACKWARD->value
            ]),
            'name' => $this->faker->randomElement([
                'ост. Конечная', 'ост. Вокзал', 'ост. Аэропорт', 'ост. Университет',
                'ост. Площадь Ленина', 'ост. Торговый центр'
            ]),
        ];
    }
}
