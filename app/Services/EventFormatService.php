<?php

namespace App\Services;

use App\Enums\RecurringTypes;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class EventFormatService
{
    public function format(Collection $events): Collection|EloquentCollection
    {
        return $events->map(function (Event $event) {


            if ($event->recurring === RecurringTypes::NONE) {
                return [
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => Carbon::parse($event->start_date . ' ' . $event->start_time)->toIso8601String(),
                    'end' => Carbon::parse($event->end_date . ' ' . $event->end_time)->toIso8601String(),
                ];
            }
            $baseEvent = [
                'id' => $event->id,
                'title' => $event->name,
                'rrule' => [
                    'dtstart' => $event->start_date,
                    'until' => $event->end_date,
                    'freq' => RecurringTypes::WEEKLY->value,
                    'interval' => ($event->recurring == RecurringTypes::WEEKLY) ? 1 : 2,
                ]
            ];

            $baseEvent['rrule']['byweekno'] = match ($event->recurring) {
                RecurringTypes::EVEN_WEEKLY => array_values(array_filter(range(1, 52), function ($week) {
                    return $week % 2 == 0;
                })),
                RecurringTypes::ODD_WEEKLY => array_values(array_filter(range(1, 52), function ($week) {
                    return $week % 2 != 0;
                })),
                default => []
            };

            return $baseEvent;
        });
    }
}
