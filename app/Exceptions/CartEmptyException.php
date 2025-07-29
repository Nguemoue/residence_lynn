<?php
declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class CartEmptyException extends RuntimeException
{
    public function __construct(string $message = 'Le panier est vide.')
    {
        parent::__construct($message);
    }
}
