<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'     => ['required', 'integer', 'exists:users,id'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['nullable', 'in:open,in_progress,completed'],
            'deadline'    => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O user_id é obrigatório.',
            'user_id.exists'   => 'O usuário informado não existe.',
            'name.required'    => 'O nome do projeto é obrigatório.',
            'status.in'        => 'Status inválido. Use: open, in_progress ou completed.',
        ];
    }
}
