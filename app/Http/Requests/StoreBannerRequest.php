<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBannerRequest extends FormRequest
{
    public function authorize(): bool { return $this->user() != null; }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:200',
            'image_url' => 'required|url',
            'link_url' => 'nullable|url',
            'position' => ['required', Rule::in(['header', 'sidebar', 'footer', 'mobile'])],
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
        ];
    }
}