<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['nullable', 'in:pending,in_progress,done'],
            'priority'    => ['nullable', 'in:low,medium,high'],
            'due_date'    => ['nullable', 'date'],
            'tag_ids'     => ['nullable', 'array'],
            'tag_ids.*'   => ['integer', 'exists:tags,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => 'O título da tarefa é obrigatório.',
            'status.in'        => 'Status inválido. Use: pending, in_progress ou done.',
            'priority.in'      => 'Prioridade inválida. Use: low, medium ou high.',
            'tag_ids.*.exists' => 'Uma ou mais tags informadas não existem.',
        ];
    }
}
