<?php
/**
 * File: UserCreateRequest
 * Created by: divino
 * Created at: 17/12/2023
 */

namespace App\Http\Requests\User;

use App\Config\Config;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Validations;

class UserCreateRequest extends FormRequest
{
    use Validations;

    public function authorize(): bool
    {
        return Config::isSuperAdmin();
    }

    public function rules(): array
    {
        $rulesAddress = $this->validateAddress(Request()->all());
        $rulesPhones = $this->validatePhones(Request()->all());
        $rulesImages = $this->validateImages(Request()->all());

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users|string|max:255|email:rfc,dns',
            'taxpayer' => 'required|string|max:18',
            'dojo_id' => 'required|exists:dojos,id',
            'password' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'birthdate' => 'nullable|date_format:Y-m-d|before:today',
            'gender' => 'nullable|string',
            'first_name' => 'nullable|string|max:255',
            ...$rulesAddress,
            ...$rulesPhones,
            ...$rulesImages
        ];
    }
}