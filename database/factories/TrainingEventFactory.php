<?php

namespace Module\Training\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Module\Training\Models\TrainingEvent;

class TrainingEventFactory extends Factory
{
    protected $model = TrainingEvent::class;

    public function definition(): array
    {
        return [
            'name' => 'Pelatihan ' . fake()->unique()->words(3, true),
            'slug' => (string) str()->uuid(),
            'startdate' => now()->addDays(7)->toDateString(),
            'finishdate' => now()->addDays(9)->toDateString(),
            'mode' => 'LKD',
            'status' => 'PUBLISHED',
        ];
    }

    public function upcoming(): static
    {
        return $this->state(fn () => [
            'status' => 'PUBLISHED',
            'startdate' => now()->addDays(14)->toDateString(),
            'finishdate' => now()->addDays(16)->toDateString(),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => 'COMPLETED',
            'startdate' => now()->subDays(20)->toDateString(),
            'finishdate' => now()->subDays(18)->toDateString(),
        ]);
    }
}
