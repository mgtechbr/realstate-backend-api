<?php

namespace App\Http\Controllers\Api;

use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function validateToken(Request $request)
    {
        $token = $request->input('token');

        if (!$token) {
            return response()->json(['message' => 'Token not provided'], 400);
        }
        $tokenRecord = PersonalAccessToken::findToken($token);

        if (!$tokenRecord) {
            return response()->json(['valid' => false, 'message' => 'Invalid token'], 401);
        }

        return response()->json(['valid' => true, 'message' => 'Valid token']);
    }
}
