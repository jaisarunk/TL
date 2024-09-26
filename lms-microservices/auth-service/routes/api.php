<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Service1Controller;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [AuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
Route::middleware('auth:api')->group(function (){
    Route::get('user',[Service1Controller::class, 'userDetails']);
    Route::get('oauth_verify', [Service1Controller::class, 'verify']);
    Route::post('register',         [Service1Controller::class, 'register']);
    Route::post('add',              [Service1Controller::class, 'add']);
    Route::get('getWeatherReport',  [Service1Controller::class, 'getWeatherReport']);
    Route::get('getWeatherReportProtected',  [Service1Controller::class, 'getWeatherReportProtected']);
    Route::get('profile',  [Service1Controller::class, 'profile']);
});
