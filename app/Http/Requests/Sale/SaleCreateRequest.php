<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class SaleCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'saleable_id' => 'nullable|string|max:25',
            'saleable_type' => 'nullable|string|max:40',
            'description' => 'nullable|string|max:255',
            'dojo_id' => 'required|string|max:25',
            'movements' => 'required|array|min:1',
            'movements.*.amount' => 'required|numeric',
            'movements.*.number' => 'required|int',
            'movements.*.entrance' => 'required|boolean',
            'movements.*.expiration_date' => 'required|date|date_format:Y-m-d',
            'movements.*.status' => 'required|string',
        ];
    }
}
