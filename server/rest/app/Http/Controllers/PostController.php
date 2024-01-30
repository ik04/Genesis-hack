<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PostController extends Controller
{
    public function createPost(CreatePostRequest $request){
        $validated = $request->validated();
        $post = Post::create([
            "title" => $validated["title"],
            "description" => $validated["description"],
            "user_id" => $request->user()->id,
            "post_uuid" => Uuid::uuid4()
        ]);
        return response()->json(["message" => "Post Created!", "post" => $post],201);
    }
    public function edit(UpdatePostRequest $request,$uuid){
        $validated = $request->validated();
        $post = Post::where("post_uuid",$uuid)->first();
        // Check if the user is authorized to edit this post
        if ($post->user_id !== $request->user()->id) {
            return response()->json(["error" => "You are not authorized to edit this post."], 403);
        }

        $post->update([
            "title" => $validated["title"],
            "description" => $validated["description"],
        ]);
        return response()->json(["message" => "Post updated successfully.", "post" => $post], 200);
    }
    public function delete($uuid,Request $request){
        $post = Post::where("post_uuid",$uuid)->first();
        if(!$post){
            return response()->json(["error" => "Post not found."], 404);

        }
        if ($post->user_id !== $request->user()->id) {
            return response()->json(["error" => "You are not authorized to edit this post."], 403);
        }

        $post->delete();
        return response()->json(["message" => "Post deleted successfully."], 200);
    }
    // ! get bugged if profile not onboarded, moke contraint or checks for that
    // todo: make another middleware to check is_first_login
    public function getPosts(){
        $posts = Post::join("profiles","profiles.user_id","=","posts.user_id")
                     ->leftJoin("post_likes", "posts.id", "=", "post_likes.post_id")
                     ->select("profiles.username","posts.title","posts.description", DB::raw("COUNT(post_likes.id) as likes"))
                     ->groupBy("posts.id")
                     ->orderby("posts.created_at","DESC")
                     ->get();
        return response()->json(["posts"=>$posts],200);
    }
    
    public function getUserPosts(Request $request){
        $posts = Post::join("profiles","profiles.user_id","=","posts.user_id")
                     ->leftJoin("post_likes", "posts.id", "=", "post_likes.post_id")
                     ->select("profiles.username","posts.title","posts.description", DB::raw("COUNT(post_likes.id) as likes"))
                     ->where("posts.user_id",$request->user()->id)
                     ->groupBy("posts.id")
                     ->orderby("posts.created_at","DESC")
                     ->get();
        return response()->json(["posts"=>$posts],200);
    }
    
    public function getPost(Request $request,$uuid){
        $posts = Post::join("profiles","profiles.user_id","=","posts.user_id")
                     ->leftJoin("post_likes", "posts.id", "=", "post_likes.post_id")
                     ->select("profiles.username","posts.title","posts.description", DB::raw("COUNT(post_likes.id) as likes"))
                     ->where("posts.user_id",$request->user()->id)
                     ->where("posts.post_uuid",$uuid)
                     ->groupBy("posts.id")
                     ->orderby("posts.created_at","DESC")
                     ->get();
        return response()->json(["posts"=>$posts],200);
    }
}
