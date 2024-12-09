<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Этаж' => $this->faker->numberBetween(1, 4),
            'Количество_мест' => $this->faker->numberBetween(1, 4),
            'Свободен' => true,
        ];
    }
}
