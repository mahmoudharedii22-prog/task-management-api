<?php

namespace App\Services;

use App\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    private UserService $userService;

    public function register(array $data): array 
    {
        $user = $this->userService->store($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];  
    }
    public function login(array $data): array
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
        if (! Auth::attempt($credentials)) {
            throw new InvalidCredentialsException('Invalid credentials');
        }
        $token = Auth::user()->createToken('auth_token')->plainTextToken;

        return [
            'user' => Auth::user(),
            'token' => $token,
        ];
    }
}
