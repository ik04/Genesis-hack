<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function onboard(CreateProfileRequest $request){
        $validated = $request->validated();
        $profile = Profile::create([
            "name" => $validated["name"],
            "username" => $validated["username"],
            "user_id" => $request->user()->id
            // ? add image/nft/avatar
        ]);
        return response()->json(["message"=>"Profile added successfully!"]);
    }
    public function edit(UpdateProfileRequest $request)
    {
        $validated = $request->validated();
        $profile = Profile::where("user_id",$request->user()->id);
        if (!$profile) {
            return response()->json(["error" => "Profile not found"], 404);
        }
        $profile->name = $validated["name"];
        $profile->username = $validated["username"];

        $profile->save();

        return response()->json(["message" => "Profile updated successfully!"]);
    }
    public function getProfile(Request $request){
        $profile = Profile::where("user_id",$request->user()->id)->select("name","username")->first();
        return response()->json(["profile"=>$profile],200);
    }
}
