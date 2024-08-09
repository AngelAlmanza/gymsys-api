<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(UserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'user' => $user,
            'status' => 'success',
            'message' => 'User created successfully',
            'token' => $user->createToken('authToken')->plainTextToken,
        ], 201);
    }

    public function signIn(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'user' => $user,
            'status' => 'success',
            'message' => 'User signed in successfully',
            'token' => $user->createToken('authToken')->plainTextToken,
        ], 200);
    }

    public function signOut(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User signed out successfully',
        ], 200);
    }
}
