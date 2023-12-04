<?php

namespace App\Data\Product;

use App\Data\ProductCategory\ProductCategoryData;
use App\Enums\StatusProduct;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ProductData extends Data
{
    public function __construct(
      public ?int $id,
      public ?ProductCategoryData $productCategory,
      public string $title,
      public string $image,
      public string $description,
      public float $price,
      public StatusProduct $status = StatusProduct::AVAILABLE,
    ) {

    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'product_category_id' => ['nullable', 'exists:product_categories,id'],
            'title' => ['required', 'string', 'between:2,100'],
            'image' =>  ['required', 'max:5120'],
            'description' => ['required', 'string', 'between:2,100'],
            'price' => ['required', 'numeric','min:0'],
        ];
    }
}
