<?php

namespace Database\Factories;

use App\Models\Stop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stop>
 */
class StopFactory extends Factory
{
    protected $model = Stop::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stopNames = [
            'ост. Площадь Революции', 'ост. Площадь Ленина', 'ост. Проспект Мира',
            'ост. Улица Победы', 'ост. Вокзал', 'ост. Аэропорт', 'ост. Центральный рынок',
            'ост. Гостиница Центральная', 'ост. Парк Культуры', 'ост. Кинотеатр Искра',
            'ост. Улица Строителей', 'ост. Больница', 'ост. Университет', 'ост. Технический институт',
            'ост. Рынок', 'ост. Библиотека', 'ост. Музей', 'ост. Цирк', 'ост. Стадион',
            'ост. Набережная', 'ост. Почта', 'ост. Администрация', 'ост. Школа №1', 'ост. Торговый центр'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($stopNames),
            'address' => $this->faker->streetAddress,
        ];
    }
}
