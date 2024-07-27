<?php

namespace App\Formatters;

use App\Enums\RecurringTypes;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class EventFormatter
{
    public function format(Collection $events): Collection|EloquentCollection
    {
        /** @var Event $event */
        return $events->map(function (Event $event) {
            $startDate = Carbon::parse($event->start_date . ' ' . $event->start_time);
            $endDate = Carbon::parse($event->end_date . ' ' . $event->end_time);

            $startTime = Carbon::parse($event->start_time);
            $endTime = Carbon::parse($event->end_time);
            $duration = $startTime->diffInMilliseconds($endTime);

            if ($event->recurring === RecurringTypes::NONE) {
                return [
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => $startDate->toDateTimeString(),
                    'end' => $endDate->toDateTimeString(),
                ];
            }
            $baseEvent = [
                'id' => $event->id,
                'title' => $event->name,
                'duration' => $duration,
                'rrule' => [
                    'dtstart' => $startDate->toDateTimeString(),
                    'until' => $event->end_date,
                    'byweekday' => $event->day_of_the_week
                ]
            ];

            $baseEvent['rrule']['freq'] = match ($event->recurring) {
                RecurringTypes::WEEKLY, RecurringTypes::ODD_WEEKLY, RecurringTypes::EVEN_WEEKLY => RecurringTypes::WEEKLY->value,
                default => ''
            };

            $baseEvent['rrule']['byweekno'] = match ($event->recurring) {
                RecurringTypes::EVEN_WEEKLY => array_values(array_filter(range($startDate->weekOfYear(), 52), function ($week) {
                    return $week % 2 == 0;
                })),
                RecurringTypes::ODD_WEEKLY => array_values(array_filter(range($startDate->weekOfYear(), 52), function ($week) {
                    return $week % 2 != 0;
                })),
                default => []
            };

            return $baseEvent;
        });
    }
}
