<?php

namespace App\Data\Order;

use App\Data\Client\ClientData;
use App\Enums\StatusOrder;
use App\Models\Client;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class OrderData extends Data
{
    public function __construct(
      public ?int $id,
      public ?ClientData $client,
      public float $total_price,
      public int $quantity,
      public StatusOrder $status = StatusOrder::PENDING
    ) {

    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'total_price' => ['required', 'numeric', 'min:0'],
            'quantity' =>  ['required', 'numeric', 'min:0'],
        ];
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
            'client' => ClientData::from(Client::find($request->client_id)),
        ]);
    }
}
