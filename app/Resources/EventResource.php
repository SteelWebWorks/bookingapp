<?php

namespace App\Resources;

use App\Enums\RecurringTypes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $startDate = Carbon::parse($this->start_date . ' ' . $this->start_time);
        $endDate = Carbon::parse($this->end_date . ' ' . $this->end_time);

        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);
        $duration = $startTime->diffInMilliseconds($endTime);
        $baseEvent = [
            'id' => $this->id,
            'title' => $this->name,
            'duration' => $duration,
            'start' => $startDate->toDateTimeString(),
            'end' => $endDate->toDateTimeString(),

        ];
        if ($this->recurring !== RecurringTypes::NONE) {

            $baseEvent['rrule'] = [
                'dtstart' => $startDate->toDateTimeString(),
                'until' => $this->end_date,
                'byweekday' => $this->day_of_the_week
            ];

            $baseEvent['rrule']['freq'] = match ($this->recurring) {
                RecurringTypes::WEEKLY, RecurringTypes::ODD_WEEKLY, RecurringTypes::EVEN_WEEKLY => RecurringTypes::WEEKLY->value,
                default => ''
            };

            $baseEvent['rrule']['byweekno'] = match ($this->recurring) {
                RecurringTypes::EVEN_WEEKLY => array_values(array_filter(range($startDate->weekOfYear(), 52), function ($week) {
                    return $week % 2 == 0;
                })),
                RecurringTypes::ODD_WEEKLY => array_values(array_filter(range($startDate->weekOfYear(), 52), function ($week) {
                    return $week % 2 != 0;
                })),
                default => []
            };
        }

        return $baseEvent;
    }
}
