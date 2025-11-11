<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($data)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        $secret = env('JWT_SECRET');

        if (! $secret) {
            return response()->json(['message' => 'JWT secret not configured'], 500);
        }

        $payload = [
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60, // 1 hour
        ];

        $token = JWT::encode($payload, $secret, 'HS256');

        return response()->json(['access_token' => $token, 'token_type' => 'bearer', 'expires_in' => 3600], 200);
    }
}
