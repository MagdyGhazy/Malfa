<?php

namespace App\Http\Enums;

enum UnitTypeEnum:int
{
    case HOTEL      = 1;
    case HOUSE    = 2;
    case APARTMENT    = 3;


    public static function getDescription(int $value): string
    {
        return match ($value) {
            1       => __('translate.hotel'),
            2       => __('translate.house'),
            3       => __('translate.apartment'),
            default => __('translate.unknown'),
        };
    }
}
