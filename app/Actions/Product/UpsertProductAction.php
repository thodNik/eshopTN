<?php

namespace App\Actions\Product;

use App\Data\Product\ProductData;
use App\Models\Product;

class UpsertProductAction
{
    public static function execute(ProductData $productData): Product
    {
        return Product::updateOrCreate([
            'id' => $productData->id,
        ],
            [
                ...$productData->all(),
                'product_category_id' => $productData->productCategory?->id,
            ]
        );
    }
}
