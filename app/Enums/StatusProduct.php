<?php

namespace App\Enums;

use App\Traits\HasEnumHelpers;

enum StatusProduct: string
{
    use HasEnumHelpers;
    case AVAILABLE = 'available';
    case PRE_ORDER_ONLY = 'pre_order_only';
    case EMPTY_STOCK = 'empty_stock';
}
