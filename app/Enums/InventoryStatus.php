<?php

namespace App\Enums;

enum InventoryStatus: string
{
    case Instock = 'EMESTOQUE';
    case Lostock = 'BAIXOESTOQUE';
    case Outofstock = 'FORADEESTOQUE';
}
