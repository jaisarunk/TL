<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (Auth::guard('api')->check()) {
        //     
        // }
        // return response()->json(['error' => 'Unauthenticated'], 401);
        $client = new Client();
        $response = $client->request('GET', 'http://127.0.0.1:8001/api/oauth_verify', [
            'headers' => [
                'Authorization' => 'Bearer ' . $jwtToken,
            ],
        ]);
        $userData = json_decode($response->getBody(), true);
        return $next($request);
        echo 'pre';
        dd($userData);
        //return $userData;
    }
}
