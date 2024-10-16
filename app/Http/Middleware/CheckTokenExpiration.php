<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTokenExpiration
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            foreach ($user->tokens as $token) {
                if ($token->expires_at && $token->expires_at < now()) {
                    $token->delete();
                    return response()->json(['message' => 'Token expired'], 401);
                }
            }
        }

        return $next($request);
    }
}

