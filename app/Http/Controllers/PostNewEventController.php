<?php

namespace App\Http\Controllers;

use App\Formatters\EventFormatter;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Repositories\EventRepository;

class PostNewEventController extends Controller
{
    public function __construct(protected EventRequest $request, protected EventRepository $eventRepository)
    {
    }

    public function __invoke()
    {
        try {
            $event = $this->request->validated();
            Event::create($event);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $exception->getCode());
        }
        return response()->json([
            'success' => true,
            'message' => __('Event created successfully'),
        ]);
    }
}
