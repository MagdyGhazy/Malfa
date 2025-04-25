<?php

namespace App\Http\Enums;

enum UserTypeEnum:int
{
    case ADMIN      = 1;
    case PARTNER    = 2;
    case VISITOR    = 3;
    case GUEST      = 4;

    public static function getDescription(int $value): string
    {
        return match ($value) {
            1       => __('translate.admin'),
            2       => __('translate.partner'),
            3       => __('translate.visitor'),
            4       => __('translate.guest'),
            default => __('translate.unknown'),
        };
    }
}
