<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class update_article_requests extends FormRequest
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
        // 'sometimes' means it only validates if the field is present in the request.
        // This is perfect for PATCH requests.
        return [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'summary' => 'nullable|string|max:500',
            'main_image' => 'nullable|string|max:255',
            'sub_images' => 'nullable|array',
            'sub_images.*' => 'nullable|string|max:255',
            'categories' => 'nullable|string|max:255',
            'est' => 'nullable|string|max:255',
            'keywords' => 'nullable|string|max:255',
        ];
    }
}