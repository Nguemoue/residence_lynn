<?php
declare(strict_types=1);

use App\Exceptions\PaymentFailedException;

it('creates a payment failed exception', function () {
    $e = PaymentFailedException::dueToGateway();
    expect($e)->toBeInstanceOf(PaymentFailedException::class)
        ->and($e->getMessage())->toBe('Le paiement a échoué auprès du prestataire.');
});
