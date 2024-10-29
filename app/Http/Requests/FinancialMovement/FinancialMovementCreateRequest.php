<?php

namespace App\Http\Requests\FinancialMovement;

use Illuminate\Foundation\Http\FormRequest;

class FinancialMovementCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
//            'name' => 'required|string|max:255'
        ];
    }
}
