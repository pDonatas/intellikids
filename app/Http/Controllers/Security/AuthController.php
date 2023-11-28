<?php

declare(strict_types=1);

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(AuthRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], status: Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user?->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], status: Response::HTTP_OK);
    }

    public function logout(): JsonResponse
    {
        $token = Auth::user()?->currentAccessToken();

        assert($token instanceof PersonalAccessToken);

        $token->delete();

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
