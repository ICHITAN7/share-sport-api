<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Store_highlight_requests extends FormRequest
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
        return [
            'match_id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|string|max:255', // You could also add the 'url' rule
            'categories' => 'nullable|string|max:255',
        ];
    }
}