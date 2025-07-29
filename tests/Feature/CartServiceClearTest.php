<?php
declare(strict_types=1);

use App\Domain\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('clears the cart', function () {
    /** @var CartService $cart */
    $cart = resolve(CartService::class);
    $cart->add(1,1);
    $cart->clear();
    expect($cart->items())->toBeEmpty();
});
