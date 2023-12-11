<?php

namespace App\Actions\Order;

use App\Data\Order\OrderData;
use App\Models\Order;

class UpsertOrderAction
{
    public static function execute(OrderData $orderData): Order
    {
        return Order::updateOrCreate([
            'id' => $orderData->id,
        ],
            [
                ...$orderData->all(),
                'client_id' => $orderData->client?->id
            ]
        );
    }
}
