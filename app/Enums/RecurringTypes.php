<?php

namespace App\Enums;

enum RecurringTypes: string
{
    case NONE = 'none';
    case WEEKLY = 'weekly';
    case EVEN_WEEKLY = 'even-weekly';
    case ODD_WEEKLY = 'odd-weekly';

    public function toString(): string
    {
        return match ($this) {
            self::NONE => __('None'),
            self::WEEKLY => __('Weekly'),
            self::EVEN_WEEKLY => __('Even Weekly'),
            self::ODD_WEEKLY => __('Odd Weekly'),
        };
    }
}
