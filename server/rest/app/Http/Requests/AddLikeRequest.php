<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLikeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "post_uuid" => "required|uuid"
        ];
    }
}
