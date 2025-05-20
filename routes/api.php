<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\API\V1\PostController as APIV1PostController;
use App\Http\Controllers\API\V1\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);


Route::prefix('v1')->group(function() {
    Route::apiResource('/posts', PostController::class);
});

Route::prefix('v2')->group(function() {
    Route::apiResource('/posts', APIV1PostController::class);
});

