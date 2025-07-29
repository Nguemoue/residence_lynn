<?php
declare(strict_types=1);

namespace App\DTO;

/**
 * Représente une ligne de panier validée.
 */
final readonly class CartItemDto
{
    public function __construct(
        public int $productId,
        public int $quantity,
    ) {}
}
