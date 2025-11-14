<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class store_article_requests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // This is handled by the 'auth:sanctum' middleware in api.php
        // We can just return true here.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
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