<?php

namespace App\Enums;

use App\Traits\HasEnumHelpers;

enum StatusOrder: string
{
    use HasEnumHelpers;
    case PENDING = 'pending';
    case GATHERING_PRODUCTS = 'gathering_products';
    case SHIPPING = 'shipping';
    case COMPLETED = 'completed';
}
