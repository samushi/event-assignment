<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Auth Domain
Route::prefix('auth')
    ->as('auth:')
    ->group(fn () => require app_path('../Domain/Auth/api.php'));

// Healthcheck routes
Route::get('/ping', fn () => response()->json(['pong' => true]));
