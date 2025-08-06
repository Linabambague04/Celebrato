<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventSecurity>
 */
class EventSecurityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => 1,
            'access_code' => strtoupper(fake()->bothify('SEC###')),
            'security_type' => 'Policía',
            'incident_id' => null,
            'date' => now(),
        ];
    }
}
