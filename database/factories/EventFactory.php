<?php

namespace Database\Factories;

use App\Enums\RecurringTypes;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
            'recurring' => RecurringTypes::cases()[rand(0, count(RecurringTypes::cases())-1)],
        ];
    }
}
