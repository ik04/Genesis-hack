<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;
    protected $fillable = [
        "is_honey_pot",
        "description",
        "post_id",
        "user_id",
        "post_comment_uuid"
    ];
}
