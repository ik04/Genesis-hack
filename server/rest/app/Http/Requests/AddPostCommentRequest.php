<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPostCommentRequest extends FormRequest
{
    
    public function rules(): array
    {
        return [
            "description" => "required|string",
            "post_uuid" => "required|uuid"
        ];
    }
}
