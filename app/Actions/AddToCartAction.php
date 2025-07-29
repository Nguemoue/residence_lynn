<?php
declare(strict_types=1);

namespace App\Actions;

use App\DTO\CartItemDto;
use App\Domain\Services\CartService;

final readonly class AddToCartAction
{
    public function __construct(private CartService $cart) {}

    public function execute(CartItemDto $dto): void
    {
        $this->cart->add($dto->productId, $dto->quantity);
    }
}
