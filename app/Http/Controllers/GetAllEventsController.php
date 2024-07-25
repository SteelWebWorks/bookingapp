<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        $start = Carbon::parse($request->input('start'));
        $end = Carbon::parse($request->input('end'));
        $events = $this->eventService->getAllEvents($start, $end)->toArray();

        return response()->json($events);
    }
}
