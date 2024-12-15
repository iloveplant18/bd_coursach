<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = $this->faker->dateTimeBetween('+15 days', '+60 days');
        $end_date = $this->faker->dateTimeBetween($start_date, '+60 days');

        return [
            'Дата_совершения_бронирования' => $this->faker->dateTimeBetween('-60 days', $start_date),
            'Дата_заезда' => $start_date,
            'Дата_выезда' => $end_date,
        ];
    }

    public function oneAfterAnother($step = 5, $start = 1) {
        return $this->sequence(
            fn (Sequence $sequence) => [
                'Дата_заезда' => new DateTime($start + $sequence->index * $step . ' days'),
                'Дата_выезда' => new DateTime($start -1 + ($sequence->index + 1) * $step . ' days'),
            ]
        );
    }
}
