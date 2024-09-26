<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $url ="http://127.0.0.1:8001/api/oauth_verify";
        //$token = $request->token;
        $token = $request->header('Authorization');
        $token = explode(' ', $token);
        //dd($token[1]);
        $response = Http::withHeaders([
            'Authorization'=>'Bearer '.$token[1],
            'Content-Type'=>'application/json',
        ])->get($url);
        //echo '<pre>';
        //dd($response->json());
        //return $data;
            $result = $response->json();
            //dd($result);
            //dd(gettype($result));
            if ($result ==null || $result['status'] == false) {
                return response()->json(['message'=>'Unauthorized','status'=>false],401);
            }    
            return $next($request);
        //return $next($request);


        // $client = new Client();
        // $response = $client->request('GET', 'http://127.0.0.1:8001/api/oauth_verify', [
        //     'headers' => [
        //         'Authorization' => 'Bearer ' . $jwtToken,
        //     ],
        // ]);
        // $userData = json_decode($response->getBody(), true);
        // return $next($request);
        // echo 'pre';
        // dd($userData);
        //return $userData;
    }
}
