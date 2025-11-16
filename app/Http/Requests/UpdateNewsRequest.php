<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $newsId = $this->route('news')->id;

        return [
            'title' => 'sometimes|string|max:255',
            'slug' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('news')->ignore($newsId),
            ],
            'summary' => 'nullable|string',
            'content' => 'sometimes|string',
            'thumbnail_url' => 'nullable|url',
            'image_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'category_id' => 'sometimes|exists:categories,id',
            'is_breaking' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'is_published' => 'sometimes|boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}