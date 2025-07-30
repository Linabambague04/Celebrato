<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organizer_id' => 1, 
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(2),
            'location' => fake()->city(),
            'status' => 'activo',
        ];
    }
}
