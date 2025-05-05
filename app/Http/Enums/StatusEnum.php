<?php

namespace App\Http\Enums;

enum StatusEnum:int
{
    case INACTIVE    = 0;

    case ACTIVE      = 1;


    public static function getDescription(int $value): string
    {
        return match ($value) {
            1       => __('translate.active'),
            0       => __('translate.inactive'),
            default => __('translate.unknown'),
        };
    }
}
