<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        // Проверяем email + password
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = $request->user();

        // Создаём токен API
        $token = $user->createApiToken();

        // Возвращаем JSON с пользователем и токеном
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            // Удаляем все токены пользователя
            $user->tokens()->delete();
        }

        return response()->json([
            'message' => 'Logged out',
        ]);
    }
}