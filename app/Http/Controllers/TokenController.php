<?php

namespace App\Http\Controllers;

use App\Services\TokenService;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    function generateToken(Request $request, TokenService $tokenService)
    {
        $token = $tokenService->create();
        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }
}
