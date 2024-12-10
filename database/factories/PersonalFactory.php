<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personal>
 */
class PersonalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ФИО' => $this->faker->name(),
            'Дата_рождения' => $this->faker->dateTimeBetween('-40 years', '-18 years'),
            'Должность' => $this->faker->randomElement(['Администратор', 'Официант', 'Горничная']),
        ];
    }
}
