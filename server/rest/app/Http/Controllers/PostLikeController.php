<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyLikedException;
use App\Exceptions\NoLikeException;
use App\Http\Requests\AddLikeRequest;
use App\Models\PostLike;
use App\Services\PostService;
use Exception;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function __construct(protected PostService $service)
    {
        
    }
    public function like(AddLikeRequest $request){
        try{
            $validated = $request->validated();
            $postId = $this->service->getPostId($validated["post_uuid"]);
            $isLiked = PostLike::where("post_id",$postId)->where("user_id",$request->user()->id)->exists();
            if($isLiked){
                throw new AlreadyLikedException(message:"Post has already been liked by this user.",code:409);
            }
            $like = PostLike::create([
                "post_id" => $postId,
                "user_id" => $request->user()->id
            ]);
            return response()->json(["message" => "Post Liked!"],201);
        }catch(Exception $e){
            return response()->json(["error" => $e->getMessage()],$e->getCode());
        }
        
    }
    public function unlike(Request $request,$uuid){
        try{
            $postId = $this->service->getPostId($uuid);
            $isLiked = PostLike::where("post_id",$postId)->where("user_id",$request->user()->id)->first();
            if(!$isLiked){
                throw new NoLikeException(message:"Can't Unlike a post that hasn't been liked.",code:404);
            }
            return response()->json(["message" => "Post Unliked!"],200);
        }catch(Exception $e){
            return response()->json(["error" => $e->getMessage()],$e->getCode());
        }
    }
    
}
