<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPostCommentRequest;
use App\Models\PostComment;
use App\Services\PostService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PostCommentController extends Controller
{
    public function __construct(protected PostService $postService)
    {
        
    }
    public function addComment(AddPostCommentRequest $request){
        try{
            $validated = $request->validated();
            $postId = $this->postService->getPostId($validated["post_uuid"]);
            $postComment = PostComment::create([
                "post_id" => $postId,
                "user_id" => $request->user()->id,
                "description" => $validated["description"],
                "post_comment_uuid" => Uuid::uuid4()
            ]);
            return response()->json(["message" => "Comment Added successfully!"],201);
        }catch(Exception $e){
            return response()->json(["error" => $e->getMessage()],$e->getCode());
        }
    }
    public function getComments($uuid){
        // try {
            $postId = $this->postService->getPostId($uuid);
    
            $comments = PostComment::where("post_id", $postId)
                                    ->leftJoin("comment_likes", "post_comments.id", "=", "comment_likes.post_comment_id")
                                    ->leftJoin("profiles", "post_comments.user_id", "=", "profiles.user_id")
                                    ->select("post_comments.description", "post_comments.is_honey_pot", "post_comments.post_comment_uuid", DB::raw("COUNT(comment_likes.id) as likes"), "profiles.username")
                                    ->groupBy("post_comments.id")
                                    ->get();
    
            return response()->json(["comments"=>$comments],200);
        // } catch(Exception $e) {
        //     return response()->json(["error" => $e->getMessage()], $e->getCode());
        // }
    }

    public function userGetComments($uuid){
        try {
            $postId = $this->postService->getPostId($uuid);
            $userId = auth()->id(); // Get the ID of the authenticated user
    
            $comments = PostComment::where("post_id", $postId)
                                    ->leftJoin("comment_likes", function ($join) use ($userId) {
                                        $join->on("post_comments.id", "=", "comment_likes.comment_id")
                                             ->where("comment_likes.user_id", "=", $userId); // Check if the user has liked each comment
                                    })
                                    ->leftJoin("profiles", "post_comments.user_id", "=", "profiles.user_id")
                                    ->select("post_comments.description", "post_comments.is_honey_pot", "post_comments.post_comment_uuid", DB::raw("COUNT(comment_likes.id) as likes"), "profiles.username", DB::raw("IF(comment_likes.user_id IS NULL, 0, 1) as is_liked"))
                                    ->groupBy("post_comments.id")
                                    ->get();
    
            return response()->json(["comments"=>$comments], 200);
        } catch(Exception $e) {
            return response()->json(["error" => $e->getMessage()], $e->getCode());
        }
    }
    
    // todo: add comments later
}
