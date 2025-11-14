<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class update_highlight_requests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // 'sometimes' allows for partial updates (PATCH)
        return [
            'match_id' => 'sometimes|nullable|integer',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'video_url' => 'sometimes|required|string|max:255',
            'categories' => 'sometimes|nullable|string|max:255',
        ];
    }
}