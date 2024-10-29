<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentCreateRequest extends FormRequest {
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|string',
            'amount_paid' => 'required|numeric',
            'paid_at' => 'required|date_format:Y-m-d',
            'interest' => 'required|numeric',
            'late_fee' => 'required|numeric',
            'discount' => 'required|numeric',
            'dojo_id' => 'required|string',
            'financial_movement_id' => 'required|string|exists:financial_movements,id',
        ];
    }
}
