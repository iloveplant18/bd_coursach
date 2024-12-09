<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Номер_телефона' => $this->faker->phoneNumber(),
            'Дата_рождения' => $this->faker->dateTimeBetween('-40 years', '-18 years'),
            'Адрес_проживания' => $this->faker->address(),
            'Паспорт' => $this->faker->numerify('##########'),
        ];
    }
}
