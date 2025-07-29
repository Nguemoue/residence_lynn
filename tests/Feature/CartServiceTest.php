<?php
declare(strict_types=1);

use App\Domain\Services\CartService;


it('adds, updates and removes items correctly', function () {
    /** @var CartService $cart */
    $cart = app(CartService::class);
    $cart->add(1, 2);
    expect($cart->items())->toHaveCount(1);

    $cart->update(1, 5);
    expect($cart->items()->first()['quantity'])->toBe(5);

    $cart->remove(1);
    expect($cart->items())->toBeEmpty();
});
