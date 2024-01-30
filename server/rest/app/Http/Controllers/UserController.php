<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateUserRequest;
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
}
