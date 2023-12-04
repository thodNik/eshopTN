<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Client\UpsertClientAction;
use App\Data\Client\ClientData;
use App\Filter\SearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ClientController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ClientResource::collection(
            QueryBuilder::for(Client::class)
                ->allowedFilters([AllowedFilter::custom('search', new SearchFilter(app(Client::class)))])
                ->allowedSorts(['created_at'])
                ->defaultSort('created_at')
                ->paginate(request()->paginate ?? 50)
                ->appends(request()->query())
        );

    }

    public function show(Client $client): ClientResource
    {
        return ClientResource::make($client);
    }

    public function store(ClientData $clientData): ClientResource
    {
        $client = UpsertClientAction::execute($clientData);

        return ClientResource::make($client);
    }

    public function update(ClientData $clientData): ClientResource
    {
        $client = UpsertClientAction::execute($clientData);

        return ClientResource::make($client);
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json([
            'message' => 'Client deleted successfully.',
        ]);
    }
}
