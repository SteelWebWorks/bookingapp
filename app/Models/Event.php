<?php

namespace App\Models;

use App\Enums\RecurringTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'day_of_the_week',
        'recurring',
    ];

    protected $casts = [
        'recurring' => RecurringTypes::class
    ];

    public function scopeBetweenDates(Builder $query, Carbon $startDate, Carbon $endDate)
    {
        $start = $startDate->startOfDay();
        $end = $endDate->endOfDay();
        return $query->orWhere(function (Builder $query) use ($start, $end) {
            $query->where('recurring', '!=', RecurringTypes::NONE)
                ->whereBetween('start_date', [$start, $end])
                ->orWhere('start_date', '<', $start)
                ->whereNull('end_date');
        })->orWhere(function (Builder $query) use ($start, $end) {
            $query->where('recurring', '!=', RecurringTypes::NONE)
                ->where('start_date', '<', $start)
                ->whereBetween('end_date', [$start, $end]);
        })->orWhere(function (Builder $query) use ($start, $end) {
            $query->where('recurring', '!=', RecurringTypes::NONE)
                ->where('start_date', '<', $start)
                ->where('end_date', '>', $end);
        })->orWhere(function (Builder $query) use ($start, $end) {
            $query->where('recurring', '=', RecurringTypes::NONE)
                ->where('start_date', '>=', $start)
                ->where('end_date', '<=', $end);
        });
    }
}
