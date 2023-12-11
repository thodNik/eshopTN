<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Order\UpsertOrderAction;
use App\Data\Order\OrderData;
use App\Filter\SearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return OrderResource::collection(
            QueryBuilder::for(Order::class)
                ->allowedFilters([AllowedFilter::custom('search', new SearchFilter(app(Order::class)))])
                ->allowedSorts(['created_at'])
                ->defaultSort('created_at')
                ->paginate(request()->paginate ?? 50)
                ->appends(request()->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderData $orderData): JsonResponse
    {
        $order = UpsertOrderAction::execute($orderData);
dd($order);
        return response()->json([
            'message' => 'Order created successfully',
            'order' => OrderResource::make($order->load('client'))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): OrderResource
    {
        return OrderResource::make($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderData $orderData): JsonResponse
    {
        $order = UpsertOrderAction::execute($orderData);

        return response()->json([
            'message' => 'Order created successfully',
            'order' => OrderResource::make($order)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): void
    {
        $order->delete();

        response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }
}
