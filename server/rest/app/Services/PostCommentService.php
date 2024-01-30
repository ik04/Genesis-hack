<?php

namespace App\Services;

use App\Exceptions\InvalidUuidException;
use App\Models\PostComment;

class PostCommentService{
    public function getPostCommentId($uuid){
        $id = PostComment::where("post_comment_uuid",$uuid)->first();
        if(!$id){
            throw new InvalidUuidException(message:"Invalid Post uuid",code:400);
        }
        $id = $id->id;
        return $id;
    }
}