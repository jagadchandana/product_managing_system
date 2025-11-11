<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VerifyJwt
{
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization', '') ?: $request->bearerToken();

        if (!$header) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = preg_replace('/^Bearer\s+/i', '', $header);

        $secret = env('JWT_SECRET');

        if (!$secret) {
            return response()->json(['message' => 'JWT secret not configured'], 500);
        }

        try {
            $payload = JWT::decode($token, new Key($secret, 'HS256'));
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Invalid token', 'error' => $e->getMessage()], 401);
        }

        $sub = $payload->sub ?? $payload->user_id ?? null;

        if (!$sub) {
            return response()->json(['message' => 'Invalid token payload'], 401);
        }

        $user = User::find($sub);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 401);
        }

        Auth::loginUsingId($user->id);

        return $next($request);
    }
}
