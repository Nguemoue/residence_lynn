<?php

declare(strict_types=1);

namespace App\Infrastructure\Payment;

use App\Domain\Contracts\PaymentGatewayContract;
use Stripe\PaymentIntent;
use Stripe\Refund;

final class StripeGateway implements PaymentGatewayContract
{
    public function createPayment(float $amount, string $currency = 'eur', array $meta = []): string
    {
        $intent = PaymentIntent::create([
            'amount' => (int) round($amount * 100),
            'currency' => $currency,
            'metadata' => $meta,
        ]);

        return $intent->id;
    }

    public function retrievePayment(string $paymentIntentId): ?array
    {
        return PaymentIntent::retrieve($paymentIntentId)?->toArray();
    }

    public function refund(string $paymentIntentId, ?float $amount = null): bool
    {
        Refund::create([
            'payment_intent' => $paymentIntentId,
            'amount' => $amount ? (int) round($amount * 100) : null,
        ]);

        return true;
    }
}
