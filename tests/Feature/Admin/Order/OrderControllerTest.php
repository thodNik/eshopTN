<?php

use App\Models\Order;

uses()->group('orders', 'admin');

beforeEach(function () {
    adminLogin();
    $this->order = Order::factory()->create();
});

it('can view all orders', function () {

    Order::factory()->count(5)->create();

    $response = $this->get(route('admin.orders.index'))->assertStatus(200);

    expect($response->json('data'))->toHaveCount(6);
});

it('can view a order', function () {

    $response = $this->get(route('admin.orders.show', $this->order))->assertStatus(200);

    expect($response->json('data'))->toContain($this->order->id);
});

it('can store a order', function () {
    $response = $this->post(route('admin.orders.store'), [
        'client_id' => $this->order->client_id,
        'total_price' => $this->order->total_price,
        'quantity' =>  $this->order->quantity,
        'status' => $this->order->status->value,
    ])->assertStatus(200);

    expect($response->json('order'))->dd()
        ->client->id->toBe($this->order->client_id)
        ->total_price->toBe($this->order->total_price)
        ->quantity->toBe($this->order->quantity)
        ->status->toBe($this->order->status->value);
})->only();

it('can update a order', function () {
    $productCategory = ProductCategory::factory()->create();
    $product = Product::factory()->create();

    $response = $this->put(route('admin.orders.update', $this->product), [
        'product_category_id' => $productCategory->id,
        'title' => $product->title,
        'image' =>  $product->image,
        'description' => $product->description,
        'price' => $product->price,
    ])->assertStatus(200);

    expect($response->json('product'))
        ->productCategory->id->toBe($productCategory->id)
        ->title->toBe($product->title)
        ->image->toBe($product->image)
        ->description->toBe($product->description)
        ->price->toBe($product->price);
});

it('can delete a order', function () {

    $response = $this->delete(route('admin.orders.destroy', $this->product))->assertStatus(200);

    expect($response->json('data'))->toBeEmpty();

    $this->assertDatabaseMissing('products', ['id' => $this->product->id]);
});

it('can search a order', function () {
    Product::factory(5)->create();

    $value = $this->product->title;

    $response = $this->get(route('admin.orders.index', ['filter[search]' => $value]))->assertStatus(200);

    expect($response->json('data'))->toHaveCount(1)
        ->and($response->json('data')[0])->toContain($value);

});
