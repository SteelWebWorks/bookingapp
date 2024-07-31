<?php

namespace App\Http\Controllers;

use App\Formatters\EventFormatter;
use App\Models\Event;
use App\Repositories\EventRepository;
use App\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class GetAllEventsController extends Controller
{

    public function __construct(protected EventRepository $eventRepository)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(string $startDate, string $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        /** @var Collection $events */
        $events = $this->eventRepository->getAllEvents($start, $end);

        return EventResource::collection($events);
    }
}
