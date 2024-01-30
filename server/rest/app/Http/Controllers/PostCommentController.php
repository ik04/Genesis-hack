<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPostCommentRequest;
use App\Models\PostComment;
use App\Services\PostService;
use Exception;
use Illuminate\Http\Request;
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
    // todo: add comments later
}
