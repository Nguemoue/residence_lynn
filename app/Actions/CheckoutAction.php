<?php
declare(strict_types=1);

namespace App\Actions;

use App\Domain\Services\CartService;
use App\Domain\Services\CheckoutService;
use App\DTO\CheckoutDataDto;
use App\Exceptions\CartEmptyException;
use App\Models\Order;

final readonly class CheckoutAction
{
    public function __construct(private CheckoutService $service, private CartService $cart)
    {
    }

    public function execute(CheckoutDataDto $dto): Order
    {
        if ($this->cart->items()->isEmpty()) {
            throw new CartEmptyException();
        }
        $order = $this->service->process($dto);
        //clear the cart
        $this->cart->clear();
        //event(new OrderCreateEvent(reference: $reference,order: $order));
        return $order;
    }
}
