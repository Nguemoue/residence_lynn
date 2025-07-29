<?php
declare(strict_types=1);

use App\Actions\UpdateCartItemAction;
use App\DTO\CartItemDto;
use App\Domain\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('updates cart item quantity', function () {
    /** @var CartService $cart */
    $cart = app(CartService::class);
    $cart->add(1, 1);

    /** @var UpdateCartItemAction $update */
    $update = app(UpdateCartItemAction::class);
    $update->execute(new CartItemDto(1, 7));

    expect($cart->items()->first()['quantity'])->toBe(7);
});
