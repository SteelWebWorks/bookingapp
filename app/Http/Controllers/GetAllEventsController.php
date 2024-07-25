<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;

class GetAllEventsController extends Controller
{

    public function __construct(protected EventService $eventService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $events = $this->eventService->getAllEvents()->toArray();

        return response()->json($events);
    }
}
