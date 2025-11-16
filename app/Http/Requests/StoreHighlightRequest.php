<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreHighlightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() != null; // Logged in users
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('title') && !$this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:highlights,slug',
            'summary' => 'nullable|string',
            'video_url' => 'required|url',
            'is_featured' => 'sometimes|boolean',
            'is_published' => 'sometimes|boolean',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
