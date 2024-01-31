<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyLikedException;
use App\Exceptions\NoLikeException;
use App\Http\Requests\AddLikeCommentRequest;
use App\Http\Requests\AddLikeRequest;
use App\Models\CommentLike;
use App\Services\PostCommentService;
use App\Services\PostService;
use Exception;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    public function __construct(protected PostCommentService $service)
    {
        
    }
    public function like(AddLikeCommentRequest $request){
        try{
            $validated = $request->validated();
            $postCommentId = $this->service->getPostCommentId($validated["post_comment_uuid"]);
            $isLiked = CommentLike::where("post_comment_id",$postCommentId)->where("user_id",$request->user()->id)->exists();
            if($isLiked){
                throw new AlreadyLikedException(message:"Post has already been liked by this user.",code:409);
            }
            $like = CommentLike::create([
                "post_comment_id" => $postCommentId,
                "user_id" => $request->user()->id
            ]);
            return response()->json(["message" => "Comment Liked!"],201);
        }catch(Exception $e){
            return response()->json(["error" => $e->getMessage()],$e->getCode());
        }
        
    }
    public function unlike(Request $request,$uuid){
        try{
            $postId = $this->service->getPostCommentId($uuid);
            $isLiked = CommentLike::where("post_comment_id",$postId)->where("user_id",$request->user()->id)->first();
            if(!$isLiked){
                throw new NoLikeException(message:"Can't Unlike a post that hasn't been liked.",code:404);
            }
            return response()->json(["message" => "Comment Unliked!"],200);
        }catch(Exception $e){
            return response()->json(["error" => $e->getMessage()],$e->getCode());
        }
    }
}
