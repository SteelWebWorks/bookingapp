<?php

namespace App\Rules;

use App\Enums\RecurringTypes;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use Illuminate\Support\Facades\DB;

class NoOverlap implements ValidationRule
{
    public function __construct(protected string $recurring, protected int $dayOfTheWeek, protected string $startTime, protected string $endTime)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $query = DB::table('events');

        if ($this->recurring !== RecurringTypes::NONE->value) {
            $query->where('recurring', '!=', RecurringTypes::NONE->value);
        }

        $start_time = $this->startTime;
        $end_time = $this->endTime;

        $query->where('day_of_the_week', $this->dayOfTheWeek)
            ->where(function ($subQuery) use ($start_time, $end_time) {
            $subQuery->whereBetween('start_time', [$start_time, $end_time])
                ->orWhereBetween('end_time', [$start_time, $end_time])
                ->orWhere(function ($innerQuery) use ($start_time, $end_time) {
                    $innerQuery->where('start_time', '<=', $start_time)
                        ->where('end_time', '>=', $end_time);
                });
        });
        $events = $query->get();

        if ($events->count() != 0) {
            $fail(__('The event is overlapping with an another existing event'));
        }
    }
}
