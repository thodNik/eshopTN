<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Product\UpsertProductAction;
use App\Data\Product\ProductData;
use App\Filter\SearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(
            QueryBuilder::for(Product::class)
                ->allowedFilters([AllowedFilter::custom('search', new SearchFilter(app(Product::class)))])
                ->allowedSorts(['created_at'])
                ->defaultSort('created_at')
                ->paginate(request()->paginate ?? 50)
                ->appends(request()->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductData $productData): ProductResource
    {
       $product = UpsertProductAction::execute($productData);

        return ProductResource::make($product->load('productCategory'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductData $productData): ProductResource
    {
        $product = UpsertProductAction::execute($productData);

        return ProductResource::make($product->load('productCategory'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }
}
