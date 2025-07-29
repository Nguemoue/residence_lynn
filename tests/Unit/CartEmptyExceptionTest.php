<?php
declare(strict_types=1);

use App\Exceptions\CartEmptyException;

it('creates cart empty exception', function () {
    $e = new CartEmptyException();
    expect($e)->toBeInstanceOf(CartEmptyException::class)
        ->and($e->getMessage())->toBe('Le panier est vide.');
});
