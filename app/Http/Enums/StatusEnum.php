<?php

namespace App\Http\Enums;

enum StatusEnum:int
{
    case INACTIVE    = 1;

    case ACTIVE      = 2;


    public static function getDescription(int $value): string
    {
        return match ($value) {
            1       => __('translate.inactive'),
            2       => __('translate.active'),
            default => __('translate.unknown'),
        };
    }
}
