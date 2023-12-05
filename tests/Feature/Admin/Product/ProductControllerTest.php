<?php

use App\Models\Product;
use App\Models\ProductCategory;

uses()->group('products', 'admin');

beforeEach(function () {
    adminLogin();
    $this->productCategory = ProductCategory::factory()->create();
    $this->product = Product::factory()->create(['product_category_id' => $this->productCategory->id]);
});

it('can view all products', function () {

    Product::factory()->count(5)->create();

    $response = $this->get(route('admin.products.index'))->assertStatus(200);

    expect($response->json('data'))->toHaveCount(6);
});

it('can view a product', function () {

    $response = $this->get(route('admin.products.show', $this->product))->assertStatus(200);

    expect($response->json('data'))->toContain($this->product->id);
});

it('can store a product', function () {
    $response = $this->post(route('admin.products.store'), [
        'product_category_id' => $this->productCategory->id,
        'title' => $this->product->title,
        'image' =>  $this->product->image,
        'description' => $this->product->description,
        'price' => $this->product->price,
    ])->assertStatus(201);

    expect($response->json('data'))
        ->productCategory->id->toBe($this->productCategory->id)
        ->title->toBe($this->product->title)
        ->image->toBe($this->product->image)
        ->description->toBe($this->product->description)
        ->price->toBe($this->product->price);
});

it('can update a product', function () {
    $productCategory = ProductCategory::factory()->create();
    $product = Product::factory()->create();

    $response = $this->put(route('admin.products.update', $this->product), [
        'product_category_id' => $productCategory->id,
        'title' => $product->title,
        'image' =>  $product->image,
        'description' => $product->description,
        'price' => $product->price,
    ])->assertStatus(201);

    expect($response->json('data'))
        ->productCategory->id->toBe($productCategory->id)
        ->title->toBe($product->title)
        ->image->toBe($product->image)
        ->description->toBe($product->description)
        ->price->toBe($product->price);
});

it('can delete a product', function () {

    $response = $this->delete(route('admin.products.destroy', $this->product))->assertStatus(200);

    expect($response->json('data'))->toBeEmpty();

    $this->assertDatabaseMissing('products', ['id' => $this->product->id]);
});

it('can search a product', function () {
    Product::factory(5)->create();

    $value = $this->product->title;

    $response = $this->get(route('admin.products.index', ['filter[search]' => $value]))->assertStatus(200);

    expect($response->json('data'))->toHaveCount(1)
        ->and($response->json('data')[0])->toContain($value);

});
