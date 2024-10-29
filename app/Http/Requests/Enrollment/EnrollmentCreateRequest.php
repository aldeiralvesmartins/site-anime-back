<?php

namespace App\Http\Requests\Enrollment;

use App\Traits\Validations;
use Illuminate\Foundation\Http\FormRequest;

class EnrollmentCreateRequest extends FormRequest
{
    use Validations;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rulesEnrollments = $this->validateEnrollment();

        if (Request()->student_id) {
            return [
                'student_id' => 'required|exists:students,id',
                ...$rulesEnrollments,
            ];
        }

        $rulesAddress = $this->validateAddress(Request()->all());
        $rulesPhones = $this->validatePhones(Request()->all());

        return [
            'taxpayer_code' => 'nullable|string|min:3|max:40',
            'birthdate' => 'nullable|date_format:Y-m-d|before:today',
            'admission_date' => 'nullable|date_format:Y-m-d',
            'registrationFee' => 'nullable|array',
            ...$rulesEnrollments,
            ...$rulesAddress,
            ...$rulesPhones,
        ];
    }

    private function validateEnrollment(): array
    {
        return [
            'plan_id' => 'required|exists:plans,id',
            'payment_day' => 'nullable|numeric|max:28|min:1',
            'egress_date' => 'nullable|date_format:Y-m-d',
            'dojo_id' => 'nullable|string',
        ];
    }
}
