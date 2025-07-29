<?php
declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

class PaymentFailedException extends RuntimeException
{
    public static function dueToGateway(): self
    {
        return new self('Le paiement a échoué auprès du prestataire.');
    }
}
