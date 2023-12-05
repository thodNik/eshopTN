<?php

use App\Models\Client;

uses()->group('clients', 'admin');

beforeEach(function () {
    adminLogin();
    $this->client = Client::factory()->create();
});

it('can view all clients', function () {

    Client::factory()->count(5)->create();

    $response = $this->get(route('admin.clients.index'))->assertStatus(200);

    expect($response->json('data'))->toHaveCount(6);
});

it('can view a client', function () {

    $response = $this->get(route('admin.clients.show', $this->client))->assertStatus(200);

    expect($response->json('data'))->toContain($this->client->id);
});

it('can store a client', function () {

    $email = 'thodoris@gmail.com';

    $response = $this->post(route('admin.clients.store'), [
        'name' => fake()->name,
        'email' => $email,
        'password' => fake()->password,
        'address' => fake()->address(),
        'phone' => fake()->regexify('[0-9]{10}'),
        'zipcode' => fake()->regexify('[0-4]{5}')
    ])->assertStatus(201);

    expect($response->json('data'))
        ->email->toBe($email);
});

it('can update a client', function () {

    $response = $this->patch(route('admin.clients.update', $this->client), [
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

it('can delete a client', function () {

    $response = $this->delete(route('admin.clients.destroy', $this->client))->assertStatus(200);

    expect($response->json('data'))->toBeEmpty();

    $this->assertDatabaseMissing('clients', ['id' => $this->client->id]);
});

it('can search a client', function () {
    Client::factory(5)->create();

    $value = $this->client->name;

    $response = $this->get(route('admin.clients.index', ['filter[search]' => $value]))->assertStatus(200);

    expect($response->json('data'))->toHaveCount(1)
        ->and($response->json('data')[0])->toContain($value);

});
