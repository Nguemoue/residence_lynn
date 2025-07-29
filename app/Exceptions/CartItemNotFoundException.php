<?php
declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class CartItemNotFoundException extends RuntimeException
{
    public static function becauseItemMissing(): self
    {
        return new self('Article introuvable dans le panier.');
    }
}
