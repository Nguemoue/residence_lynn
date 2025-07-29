<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $product  = Product::factory()->create();
        $quantity = random_int(1, 3);

        return [
            'order_id'     => Order::factory(),
            'product_id'   => $product->id,
            'quantity'     => $quantity,
            'unit_price'   => $product->price,
            'total_price'  => $product->price * $quantity,
        ];
    }
}
