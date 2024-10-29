<?php

namespace App\Http\Requests\PaymentCondition;

use Illuminate\Foundation\Http\FormRequest;

class PaymentConditionCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'days_to_apply' => 'required|integer',
            'value_to_apply' => 'required|numeric|min:0',
            'is_percentage' => 'required|bool',
            'plan_id' => 'required|exists:plans,id'
        ];
    }
}