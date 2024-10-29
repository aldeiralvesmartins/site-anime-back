<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->segment(3);
        return [
            'name' => ['nullable', 'string', "unique:modalities,name,{$id},id"],
            'active' => 'nullable|boolean',
        ];
    }

}
