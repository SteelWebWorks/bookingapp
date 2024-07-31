<?php

namespace App\Http\Requests;

use App\Enums\RecurringTypes;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class EventRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'day_of_the_week' => 'required|string',
            'recurring' => [new Enum(RecurringTypes::class)],
        ];
    }

    protected function prepareForValidation()
    {
        $start = Carbon::parse($this->startDateTime);
        $end = Carbon::parse($this->endDateTime);

        return $this->merge([
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'start_time' => $start->format('H:i'),
            'end_time' => $end->format('H:i'),
            'day_of_the_week' => $this->dayOfTheWeek,
        ]);
    }
}
