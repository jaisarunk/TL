<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class Service1Controller extends Controller
{

    public function userDetails(Request $request)
    {
        return $request->user();
    }
    public function register_2(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'name' => 'required|string|max:255',                            
        //     'email' => 'required|string|email|max:255|unique:users',                         
        //     'password' => 'required|string|min:8',                        
        // ]);
        // if ($validator->fails())
        // {
        //     return response()->json(['status'=> 422,'errors' => $validator->messages(),422]);
        // }
        // else {
        //     $user = User::create([
        //         'name' => $request->name,
        //         'email' => $request->email,
        //         'password' => Hash::make($request->password),
        //     ]);
        // }      

        // return response()->json(['user' => $user], 201);
    }
    public function register(Request $request)
    {
        return response()->json(['user' => 'user'], 201);
    }
    public function add(Request $request)
    {
        //return response()->json($request->token);

        $token = $request->token;
        //return $token;
        // Get the payload (body) of the incoming request if you want to forward it
        $data = $request->all();

        // Forward the request to another URL with the token
        $response = Http::withToken($token)
            ->get('http://127.0.0.1:8002/api/getWeatherReport', $data);

        // Return the response from the external API
        return $response->json();    
    }
    public function profile(Request $request)
    {
        $url ="http://127.0.0.1:8002/api/getWeatherReport";
        $token = $request->token;
        $response = Http::withOptions([
            'verify'=>false,
        ])->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Content-Type'=>'application/json',
        ])->get($url);
        return $response->json();
        return $data;
    }

    public function getWeatherReport(Request $request)
    {
        return 'I am from api gateway';
    }
    public function getWeatherReportProtected(Request $request)
    {
        $url ="http://127.0.0.1:8002/api/getWeatherReportProtected";
        $token = $request->token;
        $response = Http::withOptions([
            'verify'=>false,
        ])->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Content-Type'=>'application/json',
        ])->get($url);
        return $response->json();
    }

    public function verify(Request $request)
    {
        return response()->json(['message'=>'token verified','status'=>true],200);
    }
}

