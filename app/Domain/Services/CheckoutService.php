<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Enums\OrderStatusEnum;
use App\DTO\CheckoutDataDto;
use App\Models\Product;
use App\Exceptions\{CartEmptyException};
use App\Models\Order;
use Illuminate\Support\Facades\DB;

final class CheckoutService
{
    public function __construct(
        private readonly CartService $cart,
    )
    {}

    public function process(CheckoutDataDto $dto): Order
    {

        return DB::transaction(function () use ($dto): Order {
            $order = Order::query()->create([
                'email' => $dto->email,
                'code'=>generate_order_reference(),
                'phone' => $dto->phone,
                'full_name' => $dto->fullName,
                'address_line1' => $dto->addressLine1,
                'city' => $dto->city,
                'postal_code' => $dto->postalCode,
                'country' => $dto->country,
                'status' => OrderStatusEnum::RECEIVED,
                'subtotal' => $this->cart->subtotal(),
                'discount' => $this->cart->shipping(),
                'total' => $this->cart->total(),
                'status_note'=>[
                    OrderStatusEnum::RECEIVED->value => " Votre commande a bien ete recu "
                ]
            ]);

            $orderItemSets = $this->cart->items()->map(/**
             * @param array{
             *      product: Product,
             *      quantity: int,
             *      unit_price: float,
             *      subtotal: float
             *  } $cartItem
             * @return array
             */ fn(array $cartItem) => [
                'order_id' => $order->id,
                'product_id' => $cartItem['product']->id,
                'unit_price' => $cartItem['unit_price'],
                'quantity' => $cartItem['quantity'],
                'total_price' => $cartItem['subtotal'],
                'created_at' => now(),
                'updated_at' => now()
            ])->all();
            $order->items()->insert($orderItemSets);

            return $order;
        });
    }

}
