<?php

use App\Models\Product;
use App\Models\ProductCategory;

uses()->group('clients', 'admin');

beforeEach(function () {
    adminLogin();
    $this->product = Product::factory()->create();
})->skip();

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
        'product_category_id' => $this->product->product_category_id,
        'title' => fake()->sentence(),
        'image' =>  fake()->imageUrl(),
        'description' => fake()->sentence(),
        'price' => fake()->numberBetween('10', '1000'),
    ])->assertStatus(201);

    expect($response->json('data'))
        ->productCategory->id->toBe($this->product->product_category_id);
});

it('can update a product', function () {

    $response = $this->patch(route('admin.products.update', $this->product), [
        'email' => 'changed@example.com',
        'name' => fake()->name,
        'password' => fake()->password,
        'address' => fake()->address(),
        'phone' => fake()->regexify('[0-9]{10}'),
        'zipcode' => fake()->regexify('[0-4]{5}')
    ])->assertStatus(201);

    expect($response->json('data'))
        ->email->toBe('changed@example.com');
});

it('can delete a product', function () {

    $response = $this->delete(route('admin.products.destroy', $this->product))->assertStatus(200);

    expect($response->json('data'))->toBeEmpty();

    $this->assertDatabaseMissing('products', ['id' => $this->product->id]);
});

it('can search a product', function () {
    Product::factory(5)->create();

    $value = $this->product->name;

    $response = $this->get(route('admin.products.index', ['filter[search]' => $value]))->assertStatus(200);

    expect($response->json('data'))->toHaveCount(1)
        ->and($response->json('data')[0])->toContain($value);

});
