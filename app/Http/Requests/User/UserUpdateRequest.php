<?php
/**
 * File: UserUpdateRequest
 * Created by: divino
 * Created at: 17/12/2023
 */

namespace App\Http\Requests\User;

use App\Config\Config;
use App\Traits\Validations;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    use Validations;

    public function authorize(): bool
    {
        return Config::isSuperAdmin();
    }

    public function rules(): array
    {
        if ($this->method() === 'PATCH') {
            return [];
        }

        $rulesAddress = $this->validateAddress(Request()->all());
        $rulesPhones = $this->validatePhones(Request()->all());
        $rulesImages = $this->validateImages(Request()->all()); //nao validado

        return [
            'name' => 'required|string|max:255',
            'taxpayer' => 'nullable|string|max:18',
            'taxpayer_code' => 'nullable|string|min:3|max:40',
            'birthdate' => 'nullable|date_format:Y-m-d|before:today',
            'gender' => 'nullable|string|max:15',
            'description' => 'nullable|string',
            ...$rulesAddress,
            ...$rulesPhones,
            ...$rulesImages
        ];
    }
}