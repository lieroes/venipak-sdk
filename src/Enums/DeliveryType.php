<?php

declare(strict_types=1);

namespace VenipakSDK\Enums;

enum DeliveryType: string
{
    case SAME_DAY = 'tswd';
    case NEXT_DAY = 'nwd';
    case NEXT_DAY_MORNING = 'nwd10';
    case NEXT_DAY_AFTERNOON = 'nwd14_17';
    case SATURDAY = 'sat';
}