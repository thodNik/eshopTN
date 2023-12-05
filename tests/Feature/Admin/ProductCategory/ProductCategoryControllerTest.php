<?php

use App\Models\Product;
use App\Models\ProductCategory;

uses()->group('products', 'admin');

beforeEach(function () {
    adminLogin();
    $this->productCategory = ProductCategory::factory()->create();
});

it('can view all product categories', function () {

    ProductCategory::factory()->count(5)->create();

    $response = $this->get(route('admin.product-categories.index'))->assertStatus(200);

    expect($response->json('data'))->toHaveCount(6);
});

it('can view a product category', function () {

    $response = $this->get(route('admin.product-categories.show', $this->productCategory))->assertStatus(200);

    expect($response->json('data'))->toContain($this->productCategory->id);
});

it('can store a product category', function () {
    $response = $this->post(route('admin.product-categories.store'), [
        'title' => $this->productCategory->title,
        'description' => $this->productCategory->description,
    ])->assertStatus(201);

    expect($response->json('data'))
        ->title->toBe($this->productCategory->title)
        ->description->toBe($this->productCategory->description);
});

it('can update a product category', function () {
    $productCategory = ProductCategory::factory()->create();

    $response = $this->put(route('admin.product-categories.update', $this->productCategory), [
        'title' => $productCategory->title,
        'description' => $productCategory->description,
    ])->assertStatus(201);

    expect($response->json('data'))
        ->title->toBe($productCategory->title)
        ->description->toBe($productCategory->description);
});

it('can delete a product category', function () {

    $response = $this->delete(route('admin.product-categories.destroy', $this->productCategory))->assertStatus(200);

    expect($response->json('data'))->toBeEmpty();

    $this->assertDatabaseMissing('product_categories', ['id' => $this->productCategory]);
});

it('can search a product category', function () {
    Product::factory(5)->create();

    $value = $this->productCategory->title;

    $response = $this->get(route('admin.product-categories.index', ['filter[search]' => $value]))->assertStatus(200);

    expect($response->json('data'))->toHaveCount(1)
        ->and($response->json('data')[0])->toContain($value);

});

