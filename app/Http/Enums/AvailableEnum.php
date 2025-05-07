<?php

namespace App\Http\Enums;

enum AvailableEnum:int
{
    case AVAILABLE    = 1;
    case NOT_AVAILABLE      = 2;


    public static function getDescription(int $value): string
    {
        return match ($value) {
            1       => __('translate.available'),
            2       => __('translate.not_available'),
            default => __('translate.unknown'),
        };
    }
}
