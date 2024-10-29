<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:categories|string|max:255',
            'entrance' => 'required|bool',
            'description' => 'nullable|string|max:255',
        ];
    }
}
