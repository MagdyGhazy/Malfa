<?php

namespace App\Http\Enums;

enum RoomTypeEnum:int
{
    case SINGLE    = 1;
    case DOUBLE    = 2;
    case TRIPLE    = 3;
    case SUITE     = 4;
    case STUDIO    = 5;
    case FAMILY    = 6;


    public static function getDescription(int $value): string
    {
        return match ($value) {
            1       => __('translate.single'),
            2       => __('translate.double'),
            3       => __('translate.triple'),
            4       => __('translate.suite'),
            5       => __('translate.studio'),
            6       => __('translate.family'),
            default => __('translate.unknown'),
        };
    }
}
