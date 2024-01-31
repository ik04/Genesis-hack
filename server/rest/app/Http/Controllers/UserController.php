<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateUserRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function authenticate(AuthenticateUserRequest $request){
        $validated = $request->validated();
        if (!$user = User::where("wallet_address",$validated["wallet_address"])->first()){
            $user = User::create([
                "wallet_address" => $validated["wallet_address"]
            ]);
        }
        $userToken = $user->createToken("myusertoken")->plainTextToken;
        unset($user->id);
        return response()->json(["user"=>$user,"user_token"=>$userToken],200)->withCookie(cookie()->forever('at',$userToken));
    }
    public function userData(Request $request){
        if(!$request->hasCookie("at")){
            return response()->json([
                'error' => "Unauthenticated"
            ],401);
        }
        if($token = \Laravel\Sanctum\PersonalAccessToken::findToken($request->cookie("at"))){
            $user = $token->tokenable;
        }
        else{
            return response()->json([
                'error' => "unauthenticated"
            ],401);
        }
        if(is_null($user)){
            return response()->json([
                'error' => "Unauthenticated"
            ],401);
        }
        $data = [
            'wallet_address' => $user->wallet_address,
            'is_first_login' => $user->is_first_login,
            'access_token' => $request -> cookie('at'),
        ];
        if(!$user->is_first_login){
            $profile = Profile::select("username","name")->where("user_id",$user->id)->first();
            $data["name"] = $profile->name;
            $data["username"] = $profile->username;
        }
        return response() -> json($data,200);
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
    }
}
