<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    // This is a public request, no auth needed.
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'user_name' => 'required|string|max:150',
            'message' => 'required|string',
        ];
    }
}