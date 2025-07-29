<?php

declare(strict_types=1);

namespace App\Payments\Providers;

use App\Payments\Contracts\SupportsWebhooks;
use App\Payments\DTO\{PaymentRequestDTO, PaymentResponseDTO, RefundRequestDTO, RefundResponseDTO, WebhookDTO};
use App\Payments\Enums\PaymentStatus;
use App\Payments\Exceptions\InvalidWebhookSignature;
use Stripe\StripeClient;

class StripeGateway extends AbstractGateway implements SupportsWebhooks
{
    public function __construct(private readonly StripeClient $stripe)
    {
    }

    public function createPayment(PaymentRequestDTO $dto): PaymentResponseDTO
    {

        $session = $this->stripe->checkout->sessions->create([
            'mode' => 'payment',
            'success_url' => $dto->returnUrl,
            'cancel_url' => $dto->cancelUrl,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $dto->currency->value,
                    'unit_amount' => $dto->amountCents,
                    'product_data' => [
                        'name' => $dto->description,
                    ],
                ],
                'quantity' => 1,
            ]],
            'metadata' => $dto->metadata + ['internal_reference' => $dto->reference, 'reference' => $dto->reference],
        ]);

        return new PaymentResponseDTO(
            gateway: 'stripe',
            reference: $session->id,
            status: PaymentStatus::PENDING,
            redirectUrl: $session->url,
            raw: $session->toArray(),
        );
    }

    public function cancel(string $reference): bool
    {
        $paymentIntent = $this->stripe->paymentIntents->cancel($reference);
        return $paymentIntent->status === 'canceled';
    }

    public function refund(RefundRequestDTO $dto): RefundResponseDTO
    {
        $refund = $this->stripe->refunds->create([
            'payment_intent' => $dto->reference,
            'amount' => $dto->amountCents,
            'metadata' => $dto->metadata,
        ]);

        return new RefundResponseDTO(
            gateway: 'stripe',
            reference: $refund->id,
            status: PaymentStatus::REFUNDED,
            raw: $refund->toArray(),
        );
    }

    public function handleWebhook(string $signatureHeader, array $payload): WebhookDTO
    {
        $endpointSecret = $this->config('webhook_secret');

        // Vérification signature (simplifiée)
        $computed = hash_hmac('sha256', json_encode($payload), $endpointSecret);
        if (!hash_equals($computed, $signatureHeader)) {
            throw new InvalidWebhookSignature('Stripe signature mismatch');
        }

        $type = $payload['type'] ?? '';
        $object = $payload['data']['object'] ?? [];
        $status = match ($type) {
            'payment_intent.succeeded' => PaymentStatus::COMPLETED,
            'payment_intent.payment_failed' => PaymentStatus::FAILED,
            'charge.refunded' => PaymentStatus::REFUNDED,
            default => PaymentStatus::PENDING,
        };

        return new WebhookDTO(
            gateway: 'stripe',
            reference: $object['id'] ?? 'unknown',
            status: $status,
            raw: $payload,
        );
    }

    public function hasSuccessPayment(string $reference): bool
    {
        $session = $this->stripe->checkout->sessions->retrieve($reference);
        return $session->payment_status === 'paid';
    }

    public function getName(): string
    {
        return 'stripe';
    }

}
