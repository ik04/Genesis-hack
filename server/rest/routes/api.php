<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
Route::get("healthcheck",function(){
    return response()->json(["message"=>"hi mom"],200);
});
Route::post("authenticate",[UserController::class,"authenticate"]);

Route::middleware(["auth:sanctum"])->group(function(){
    Route::prefix("get")->group(function(){
        Route::get("profile",[ProfileController::class,"getProfile"]);
        Route::get("posts",[PostController::class,"getPosts"]);
    });
    Route::prefix("add")->group(function(){
        Route::post("profile",[ProfileController::class,"onboard"]);
        Route::post("post",[PostController::class,"createPost"]);
    });
    Route::prefix("edit")->group(function(){
        Route::post("profile",[ProfileController::class,"edit"]);
        Route::post("post/{uuid}",[PostController::class,"edit"]);
    });
    Route::prefix("delete")->group(function(){
    });
});