<?php
declare(strict_types=1);

namespace App\Actions;

use App\DTO\CartItemDto;
use App\Domain\Services\CartService;

final readonly class UpdateCartItemAction
{
    public function __construct(private CartService $cart) {}

    public function execute(CartItemDto $dto): void
    {
        $this->cart->update($dto->productId, $dto->quantity);
    }
}
