<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class EventService
{
    public function __construct(protected EventFormatService $eventFormatService)
    {
    }

    public function getAllEvents(): Collection | EloquentCollection
    {
        return $this->eventFormatService->format(Event::all());
    }

    public function getEvent(int $id): Event
    {
        return Event::find($id);
    }

    public function createEvent(array $data): Event
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
