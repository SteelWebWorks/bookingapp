<?php

namespace App\Http\Controllers;

use App\Enums\RecurringTypes;

class GetRecurringTypesController extends Controller
{
    public function __invoke()
    {
        return response()->json(RecurringTypes::cases());
    }
}
