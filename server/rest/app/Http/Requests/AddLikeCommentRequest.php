<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLikeCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "post_comment_uuid" => "required|uuid"
        ];
    }
}
