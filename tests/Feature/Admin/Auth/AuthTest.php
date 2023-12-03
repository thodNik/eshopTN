<?php

use App\Models\Admin;
use Tymon\JWTAuth\Facades\JWTAuth;

uses()->group('auth', 'admin');

beforeEach(function () {
    $this->admin = Admin::factory()->create([
        'password' => 'password',
    ]);
    adminLogin($this->admin);
});

it('can login', function () {

    $response = $this->post(route('admin.login'), [
        'email' => $this->admin->email,
        'password' => 'password',
    ])->assertStatus(200);

    expect($response->json())->admin->id->toBe(auth('admin-api')->user()->id);
});

it('can logout', function () {

    $token = JWTAuth::fromUser($this->admin);

    $this->actingAs($this->admin);

    $response = $this->post('api/admin/auth/logout?token='.$token)->assertStatus(200);

    expect($response->json())->toContain('Έχετε αποσυνδεθεί με επιτυχία');
});

it('has me function', function () {

    $response = $this->post(route('admin.me'))->assertStatus(200);

    expect($response->json())
        ->toContain(auth('admin-api')->user()->id);
});
