<?php

namespace Database\Factories;

use App\Domain\Auth\Models\User;
use App\Domain\Event\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(50),
            'creator' => User::factory(),
            'event_date' => now()->addDays(14)->format('Y-m-d H:i'),
            'location' => 'London',
            'description' => fake()->text,
            'weather_prediction' => [
                'date' => '2024-05-10',
                'temperature' => ['average' => 14.7, 'maximum' => 19, 'minimum' => 10.4],
                'weather_description' => 'Moderate or heavy rain shower',
                'specific_time_forecast' => [
                    'time' => '2024-05-10 15:00',
                    'condition' => 'Patchy rain possible',
                    'feels_like' => 18.3,
                    'visibility' => 9.8,
                    'temperature' => 14.7,
                    'chance_of_rain' => 60,
                ],
            ],
        ];
    }
}
