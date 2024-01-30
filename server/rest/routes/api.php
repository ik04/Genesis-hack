<?php

use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
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


Route::prefix("get")->group(function(){
    Route::get("profile",[ProfileController::class,"getProfile"]);
    Route::get("posts",[PostController::class,"getPosts"]);
    Route::get("post/{uuid}",[PostController::class,"getPost"]);
    Route::get("user/posts",[PostController::class,"getUserPosts"]);
});

Route::middleware(["auth:sanctum"])->group(function(){
    Route::prefix("add")->group(function(){
        Route::post("profile",[ProfileController::class,"onboard"]);
    });
});

Route::middleware(["auth:sanctum","checkFirstLogin"])->group(function(){
    Route::prefix("get")->group(function(){
        Route::get("user/post/{uuid}",[PostController::class,"authGetPost"]);
    });
    Route::prefix("add")->group(function(){
        Route::post("post",[PostController::class,"createPost"]);
        Route::post("post/like",[PostLikeController::class,"like"]);
        Route::post("post/unlike",[PostLikeController::class,"unlike"]);
        Route::post("comment",[PostCommentController::class,"addComment"]);
        Route::post("comment/like",[CommentLikeController::class,"like"]);
        Route::post("comment/unlike",[CommentLikeController::class,"unlike"]);
    });
    Route::prefix("edit")->group(function(){
        Route::post("profile",[ProfileController::class,"edit"]);
        Route::post("post/{uuid}",[PostController::class,"edit"]);
    });
    Route::prefix("delete")->group(function(){
        Route::delete("post/{uuid}",[PostController::class,"delete"]);
    });
});
// todo: add a categories table and separate questions and posts