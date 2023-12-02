<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AdminResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin-api', ['except' => ['login']]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('admin-api')->attempt($credentials)) {
            return response()->json(['message' => 'Μη εξουσιοδοτημένος'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponse
    {
        return response()->json(AdminResource::make(auth('admin-api')->user()));
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Έχετε αποσυνδεθεί με επιτυχία']);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('admin-api')->refresh());
    }

    protected function respondWithToken(string|bool $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => null, // Set expires_in to null for forever
            'admin' => AdminResource::make(auth('admin-api')->user()),
        ]);
    }
}
