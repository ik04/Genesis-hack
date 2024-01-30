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
        // todo: attach comments too
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

/**
 * GPT explanation
 *  Joins: The query joins the posts table with the profiles table to get the username associated with each post. Additionally, it performs a left join with the post_likes table on the id column of posts and the post_id column of post_likes to include likes information for each post.

    Grouping: After joining the tables, the query uses GROUP BY posts.id to group the result set by the id column of the posts table. This means that all rows with the same id value (i.e., rows representing the same post) are grouped together.

    Aggregation: Within each group, the COUNT(post_likes.id) function is used to count the number of rows in the post_likes table that match each group. Since the join ensures that each row in the post_likes table corresponds to a like on a specific post, counting the rows effectively counts the number of likes for each post.

    Result: The query returns a result set where each row represents a post, and the likes column in each row contains the count of likes for that post. So, each post in the result set has an associated count of likes.
 */