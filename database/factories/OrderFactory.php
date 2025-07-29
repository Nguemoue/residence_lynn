<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 20, 150);

        return [
            'uuid' => (string)Str::uuid(),
            'code' => generate_order_reference(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'full_name' => $this->faker->name(),
            'address_line1' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'status' => OrderStatusEnum::RECEIVED,
            'subtotal' => $subtotal,
            'discount' => 0,
            'total' => $subtotal,
            'status_note' => collect(OrderStatusEnum::cases())->mapWithKeys(fn($item) => [
                $item->value => $this->faker->text(20)
            ])
        ];
    }
}
