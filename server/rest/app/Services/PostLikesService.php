<?php

namespace App\Services;

use App\Models\PostLike;

class PostLikesServices{
    public function getPostLikes($postId){
        $likes = PostLike::where("post_id",$postId)->count();
        return $likes;
    }
}