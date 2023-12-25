<?php

namespace App\Http\Controllers;

use App\Models\ResponseTemplate;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (! Auth::attempt($credential)) {
            return response()->json(ResponseTemplate::errInvalidCledential(), 401);
        }

        $user = Auth::user();
        if (is_null($user)) {
            return response()->json(ResponseTemplate::err500(), 500);
        }

        $newToken = new Token([
            'user_id' => $user->id,
            'access_token' => (string) Str::uuid(),
            'refresh_token' => (string) Str::uuid()
        ]);

        if (! $newToken->save()) {
            return response()->json(ResponseTemplate::err500(), 500);
        }
        
        return response()->json([
            'ok' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name
                ],
                'access_token' => $newToken->access_token,
                'refresh_token' => $newToken->refresh_token
            ]
        ]);
    }

    public function refresh(Request $request) {
        $bearerToken = $request->bearerToken();

        $token = Token::where('refresh_token',$bearerToken)->get()->first();
        if (is_null($token)) {
            return response()->json(ResponseTemplate::errInvalidRefreshToken(),401);
        }

        $token->access_token = (string) Str::uuid();
        if (! $token->save()) {
            return response()->json(ResponseTemplate::err500(), 500);
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'access_token' => $token->access_token
            ]
        ]);
    }

}
