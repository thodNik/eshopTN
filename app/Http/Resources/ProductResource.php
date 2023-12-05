<?php

namespace App\Http\Resources;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'productCategory' => ProductCategoryResource::make($this->whenLoaded('productCategory')),
            'slug' => $this->slug,
            'title' => $this->title,
            'image' => $this->image,
            'description' => $this->description,
            'price' => $this->price
        ];
    }
}
