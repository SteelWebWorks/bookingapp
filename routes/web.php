<?php

use App\Http\Controllers\GetAllEventsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('calendar');
});

Route::get('/events', GetAllEventsController::class);
