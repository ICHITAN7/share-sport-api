<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Policy handles authorization, so we just check if user is logged in.
        return $this->user() != null;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Auto-generate slug from title if not provided
        if ($this->filled('title') && !$this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }
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
            'slug' => 'required|string|max:255|unique:news,slug',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'thumbnail_url' => 'nullable|url',
            'image_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
            'is_breaking' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'is_published' => 'sometimes|boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array', // For attaching tags
            'tags.*' => 'exists:tags,id', // Check if each tag ID exists
        ];
    }
}