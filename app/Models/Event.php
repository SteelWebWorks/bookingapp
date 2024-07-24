<?php

namespace App\Models;

use App\Enums\RecurringTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
