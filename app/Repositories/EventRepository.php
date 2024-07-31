<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class EventRepository
{
    public function __construct()
    {
    }

    public function getAllEvents(Carbon $start, Carbon $end): Collection | EloquentCollection
    {
        /** @var Collection $events */
        $events = Event::betweenDates($start, $end)->get();

        return $events;
    }

    public function getEvent(int $id): Event
    {
        return Event::find($id);
    }

    public function createEvent(array $data)
    {

        return Event::create($data);
    }

    public function updateEvent(int $id, array $data): bool
    {
        return Event::find($id)->update($data);
    }

    public function deleteEvent(int $id): ?bool
    {
        return Event::find($id)->delete();
    }
}
