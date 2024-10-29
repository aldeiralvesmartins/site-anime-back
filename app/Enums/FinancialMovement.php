<?php
/**
 * File: FinancialMovement
 * Created by: divino
 * Created at: 18/11/2023
 */

namespace App\Enums;

enum FinancialMovement: string
{
    case Open = 'Open';
    case Paid = 'Paid';
    case Overdue = 'Overdue';
    case Canceled = 'Canceled';
}
