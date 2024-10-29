<?php
/**
 * File: Validations
 * Created by: divino
 * Created at: 11/11/2023
 */

namespace App\Traits;

trait Validations
{
    protected function validateAddress($request): array
    {
        if (empty($request['address'])) {
            return [];
        }

        return [
            'address.zip_code' => 'required|string|max:10',
            'address.street' => 'required|string|max:80',
            'address.number' => 'nullable|string|max:10',
            'address.complement' => 'nullable|string|max:255',
            'address.neighborhood' => 'required|string|max:255',
            'address.city_id' => 'required|integer|exists:cities,id',
            'address.company_id' => 'nullable|string|max:24|exists:companies,id',
        ];
    }

    private function validatePhones($request): array
    {
        if (empty($request['phones'])) {
            return [];
        }
        $rules = [];
        foreach ($request['phones'] as $key => $phones) {
            $rules["phones.{$key}.number"] = 'required|string';
        }
        return $rules;
    }

    protected function validateImages($request): array
    {
        if (empty($request['images'])) {
            return [];
        }
        $rules = [];
        foreach ($request['images'] as $key => $image) {
            $rules["images.{$key}.image"] = 'string|required';
        }
        return $rules;
    }
}