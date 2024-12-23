<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tariff>
 */
class TariffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Название' => $this->faker->randomElement(['Люкс', 'Стандартный', 'Эконом']),
            'Цена_за_сутки' => $this->faker->numberBetween(5,30) . '00',
        ];
    }
}
