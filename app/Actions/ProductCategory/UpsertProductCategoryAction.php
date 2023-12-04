<?php

namespace App\Actions\ProductCategory;

use App\Data\ProductCategory\ProductCategoryData;
use App\Models\ProductCategory;

class UpsertProductCategoryAction
{
    public static function execute(ProductCategoryData $productCategoryData): ProductCategory
    {
        return ProductCategory::updateOrCreate([
            'id' => $productCategoryData->id,
        ],
            [
                ...$productCategoryData->all(),
            ]
        );
    }
}
