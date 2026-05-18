<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $result = $this->service->register($validated);

        return response()->json([
            'success' => true,
            'data' =>['user' => new UserResource($result['user']),
            'token' => $result['token']],
            'message' => 'User registered successfully',
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $result = $this->service->login($validated);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
            'message' => 'User logged in successfully',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
