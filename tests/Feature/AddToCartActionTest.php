<?php
declare(strict_types=1);

use App\Actions\AddToCartAction;
use App\DTO\CartItemDto;
use App\Domain\Services\CartService;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('executes AddToCartAction', function () {
    $product = Product::factory()->create();

    /** @var AddToCartAction $action */
    $action = app(AddToCartAction::class);
    $dto    = new CartItemDto($product->id, 3);

    $action->execute($dto);

    /** @var CartService $cart */
    $cart = app(CartService::class);

    expect($cart->items())->toHaveCount(1)
        ->and($cart->items()->first()['quantity'])->toBe(3);
});
