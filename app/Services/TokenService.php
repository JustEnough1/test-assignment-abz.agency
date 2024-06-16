<?php

namespace App\Services;

use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TokenService
{

    // Create and store a new token
    function create()
    {
        $token = Str::random(100);
        $expiration = Carbon::now()->addMinutes(40);

        $newToken = new Token(["token" => hash("sha256", $token), "expires_at" => $expiration]);
        $newToken->save();

        return $token;
    }

    function isValid($token)
    {
        $tokenExists = Token::where('token', '=', hash('sha256', $token))
            ->where('expires_at', '>', Carbon::now())
            ->where('used', false)->exists();

        return $tokenExists ? true : false;
    }

    function delete($token)
    {
        Token::where('token', '=', hash('sha256', $token))->delete();
    }
}
