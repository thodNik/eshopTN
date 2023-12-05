<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ProductCategory\UpsertProductCategoryAction;
use App\Data\ProductCategory\ProductCategoryData;
use App\Filter\SearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return ProductCategoryResource::collection(
            QueryBuilder::for(ProductCategory::class)
                ->allowedFilters([AllowedFilter::custom('search', new SearchFilter(app(ProductCategory::class)))])
                ->allowedSorts(['created_at'])
                ->defaultSort('created_at')
                ->paginate(request()->paginate ?? 50)
                ->appends(request()->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryData $productCategoryData): ProductCategoryResource
    {
        $productCategory = UpsertProductCategoryAction::execute($productCategoryData);

        return ProductCategoryResource::make($productCategory);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory): ProductCategoryResource
    {
        return ProductCategoryResource::make($productCategory);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryData $productCategoryData): ProductCategoryResource
    {
        $productCategory = UpsertProductCategoryAction::execute($productCategoryData);

        return ProductCategoryResource::make($productCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory): JsonResponse
    {
        $productCategory->delete();

        return response()->json([
            'message' => 'Product Category deleted successfully.',
        ]);
    }
}
