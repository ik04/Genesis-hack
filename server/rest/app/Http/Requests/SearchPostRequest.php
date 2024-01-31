<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "query" => "string|nullable"
        ];
    }
}
