<?php

declare(strict_types=1);

namespace App\Payments\Enums;

enum Currency: string
{
    case EUR = 'EUR';
    case USD = 'USD';
    case XAF = 'XAF';
    case NGN = 'NGN';
    case XOF = 'XOF';
}
