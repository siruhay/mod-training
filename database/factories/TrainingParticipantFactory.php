<?php

namespace Module\Training\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\Training\Models\TrainingEvent;
use Module\Training\Models\TrainingParticipant;

class TrainingParticipantFactory extends Factory
{
    protected $model = TrainingParticipant::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => (string) str()->uuid(),
            'mode' => 'LKD',
            'biodata_id' => fake()->unique()->numberBetween(100000, 999999),
            'event_id' => TrainingEvent::factory(),
            'accepted_at' => null,
        ];
    }

    public function accepted(): static
    {
        return $this->state(fn () => ['accepted_at' => now()]);
    }
}
