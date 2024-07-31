<?php

namespace App\Http\Requests;

use App\Enums\RecurringTypes;
use App\Rules\NoOverlap;
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
            'start_time' => [
                'required',
                'date_format:H:i',
                new NoOverlap($this->input('recurring'), $this->input('day_of_the_week'), $this->input('start_time'), $this->input('end_time'))
            ],
            'end_time' => 'required|date_format:H:i',
            'day_of_the_week' => 'required|string',
            'recurring' => [new Enum(RecurringTypes::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'start_time.unique' => __('The selected event is overlapping another existing event')
        ];
    }

    protected function prepareForValidation()
    {
        $start = Carbon::parse($this->startDateTime);
        $end = Carbon::parse($this->endDateTime);
        if ($this->recurring !== RecurringTypes::NONE->value) {
            $endDate = Carbon::parse($this->input('endDate'));
        }

        return $this->merge([
            'start_date' => $start->format('Y-m-d'),
            'end_date' => (isset($endDate)) ? $endDate->format('Y-m-d') : $end->format('Y-m-d'),
            'start_time' => $start->format('H:i'),
            'end_time' => $end->format('H:i'),
            'day_of_the_week' => $this->dayOfTheWeek,
        ]);
    }
}
