<?php

declare(strict_types=1);

namespace App\Payments\Enums;

enum PaymentStatus: string
{
    case PENDING   = 'pending';
    case AUTHORIZED = 'authorized';
    case COMPLETED = 'completed';
    case FAILED    = 'failed';
    case CANCELED  = 'canceled';
    case REFUNDED  = 'refunded';
}
