<?php

namespace App\Actions\Client;

use App\Data\Client\ClientData;
use App\Models\Client;

class UpsertClientAction
{
    public static function execute(ClientData $clientData): Client
    {
        return Client::updateOrCreate([
            'id' => $clientData->id,
        ],
            [
                ...$clientData->all(),
            ]
        );
    }
}
