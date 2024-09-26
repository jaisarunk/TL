<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // User login and token generation
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string',                       
        ]);
        if ($validator->fails())
        {
            return response()->json(['status'=> 422,'errors' => $validator->messages(),422]);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function getWeatherReport(Request $request)
    {
        return response()->json(['message'=>'I am from Auth service']);
    }
}

