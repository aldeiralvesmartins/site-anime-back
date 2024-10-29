<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class PlanUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->method() === 'PATCH') {
            return [];
        }
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|text',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable',
            'duration' => 'required|integer|min:1'
        ];
    }
}
