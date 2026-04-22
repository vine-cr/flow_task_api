<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bio'        => ['nullable', 'string', 'max:1000'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'avatar_url' => ['nullable', 'url', 'max:2048'],
        ];
    }
}
