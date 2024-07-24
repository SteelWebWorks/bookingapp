<?php

namespace Database\Seeders;

use App\Enums\RecurringTypes;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::factory()
            ->count(5)
            ->sequence(
                [
                    'start_date' => '2024-09-08',
                    'end_date' => '2024-09-08',
                    'start_time' => '08:00:00',
                    'end_time' => '10:00:00',
                    'recurring' => RecurringTypes::NONE
                ],
                [
                    'start_date' => '2024-01-01',
                    'start_time' => '10:00:00',
                    'end_time' => '12:00:00',
                    'day_of_the_week' => 1,
                    'recurring' => RecurringTypes::EVEN_WEEKLY
                ],
                [
                    'start_date' => '2024-01-01',
                    'start_time' => '12:00:00',
                    'end_time' => '16:00:00',
                    'day_of_the_week' => 3,
                    'recurring' => RecurringTypes::ODD_WEEKLY
                ],
                [
                    'start_date' => '2024-01-01',
                    'start_time' => '10:00:00',
                    'end_time' => '16:00:00',
                    'day_of_the_week' => 5,
                    'recurring' => RecurringTypes::WEEKLY
                ],
                [
                    'start_date' => '2024-06-01',
                    'end_date' => '2024-11-30',
                    'start_time' => '16:00:00',
                    'end_time' => '20:00:00',
                    'day_of_the_week' => 4,
                    'recurring' => RecurringTypes::WEEKLY
                ]
            )
            ->create();
    }
}
