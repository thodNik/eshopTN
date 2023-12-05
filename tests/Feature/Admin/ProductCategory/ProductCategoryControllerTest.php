<?php

it('can store a product category', function () {

    $response = adminLogin()->post(route('admin.product-categories.store'), [
        'title' => 'Good',
        'description' => fake()->sentence(),
    ])->assertStatus(201);

    expect($response->json('data'))
        ->title->toBe('Good');
});
