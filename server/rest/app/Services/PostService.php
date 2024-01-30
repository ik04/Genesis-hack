<?php

namespace App\Services;

use App\Exceptions\InvalidUuidException;
use App\Models\Post;

class PostService{
    public function getPostId($uuid){
        $id = Post::where("post_uuid",$uuid)->select("id")->first();
        if(!$id){
            throw new InvalidUuidException(message:"Invalid Post uuid",code:400);
        }
        $id = $id->id;
        return $id;
    }
}