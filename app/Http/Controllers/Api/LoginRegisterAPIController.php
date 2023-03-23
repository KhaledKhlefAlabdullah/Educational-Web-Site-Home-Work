<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginRegisterAPIController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('authToken')->accessToken;

            return response()->json([
                'token' => $token->token,
                'user'=>$credentials
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

}
