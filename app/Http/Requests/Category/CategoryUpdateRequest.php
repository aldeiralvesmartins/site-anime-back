<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->segment(3);
        return [
            'name' => "required|string|unique:categories,name,{$id},id",
            'description' => 'nullable|string|max:255',
        ];
    }

}
