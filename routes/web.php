<?php

use App\Http\Controllers\GetAllEventsController;
use App\Http\Controllers\GetRecurringTypesController;
use App\Http\Controllers\PostNewEventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('calendar');
});

Route::get('/events/{startDate}/{endDate}', GetAllEventsController::class);

Route::get('/recurring-types', GetRecurringTypesController::class);

Route::post('/add-new-event', PostNewEventController::class);
