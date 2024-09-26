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
    // Register new users
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',                            
            'email' => 'required|string|email|max:255|unique:users',                         
            'password' => 'required|string|min:8',                        
        ]);
        if ($validator->fails())
        {
            return response()->json(['status'=> 422,'errors' => $validator->messages(),422]);
        }
        else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }      

        return response()->json(['user' => $user], 201);
    }
    public function register_2(Request $request)
    {
        return response()->json(['user' => 'user'], 201);
    }
    public function add(Request $request)
    {
        //return response()->json($request->token);
        $url ="http://127.0.0.1:8003/api/getWeatherReportprotected";
        $token = $request->token;
        $response = Http::withOptions([
            'verify'=>false,
        ])->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Content-Type'=>'application/json',
        ])->post($url);
        return $response->json();
        //return $data;
    }
    public function profile(Request $request)
    {
        // $url ="";
        // $token = "";
        // $response = Http::withOption([
        //     'verify'=>false,
        // ])->withHeader([
        //     'Authorization'=>'Bearer '.$token,
        //     'Content-Type'=>'application/json',
        // ])->post($url);
        // $data = $response->json();
        return response()->json($request->token);
    }

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
        return 'I am from api gateway';
    }
}

