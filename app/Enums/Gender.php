<?php
/**
 * File: Gender
 * Created by: divino
 * Created at: 9/9/23
 */

namespace App\Enums;

enum Gender: string
{
    case Masculine = 'Male';
    case Feminine = 'Female';
    case Other = 'Other';
}