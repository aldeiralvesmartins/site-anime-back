<?php

namespace App\Helpers;

class UtilsHelper
{
    public static function getValue($index, $data, $return = null)
    {
        return isset($index) && isset($data) && array_key_exists($index, $data) ? $data[$index] : $return;
    }

    public static function formatPhone($phone)
    {
        $cleanedPhone = preg_replace('/[^0-9]/', '', $phone);

        if (preg_match('/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/', $cleanedPhone, $matches)) {
            $countryCode = $matches[1];
            $areaCode = $matches[2];
            $prefix = $matches[3];
            $lineNumber = $matches[4];

            $formattedPhone = '';

            if ($countryCode) {
                $formattedPhone .= '+' . $countryCode . ' ';
            }

            if ($areaCode) {
                $formattedPhone .= '(' . $areaCode . ') ';
            }

            $formattedPhone .= $prefix . '-' . $lineNumber;
            return $formattedPhone;
        }

        return $phone;
    }

}
