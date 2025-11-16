<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLikeRequest extends FormRequest
{
    // Public request
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // No validation needed, we use request IP
        ];
    }
}