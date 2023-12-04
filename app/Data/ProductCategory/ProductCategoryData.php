<?php

namespace App\Data\ProductCategory;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ProductCategoryData extends Data
{
    public function __construct(
      public ?int $id,
      public string $title,
      public string $description
    ) {

    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'title' => ['required', 'string', 'between:2,100'],
            'description' => ['required', 'string', 'between:2,100'],
        ];
    }
}
