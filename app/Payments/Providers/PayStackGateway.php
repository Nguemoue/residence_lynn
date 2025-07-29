<?php

declare(strict_types=1);

namespace App\Payments\Providers;

use App\Payments\Exceptions\NotSupportedCurrencyException;
use Illuminate\Support\Facades\Http;
use App\Payments\DTO\{
    PaymentRequestDTO,
    PaymentResponseDTO,
    RefundRequestDTO,
    RefundResponseDTO,
    WebhookDTO
};
use App\Payments\Enums\PaymentStatus;
use App\Payments\Contracts\SupportsWebhooks;
use App\Payments\Exceptions\InvalidWebhookSignature;

class PayStackGateway extends AbstractGateway implements SupportsWebhooks
{
    public function getName(): string
    {
        return 'paystack';
    }

    public function createPayment(PaymentRequestDTO $dto): PaymentResponseDTO
    {
        $currency =  $dto->currency->value;
        $amount = $dto->amountCents;

        try {
            $this->validateCurrency(currency: $currency);
        }catch (NotSupportedCurrencyException $exception){
            $currency = $this->config('config.fallback_currency');
            $amount = (int) $this->convertAmountToCurrency(from: $dto->currency->value, amount: $dto->amountCents, to: $currency);
        }
        $amount = $this->convertToKobo(amount: $amount,currency: $currency);

        $payload = [
            'amount' => $amount,
            'email' => $dto->metadata['email'] ?? $this->config('config.payment_email')?? throw new \InvalidArgumentException('Email is required for Paystack payments.'),
            'callback_url' => $dto->returnUrl,
            'metadata' => array_merge($dto->metadata, [
                'internal_reference' => $dto->reference,
            ]),
            'currency' => $currency,
        ];

        $response = Http::withToken($this->config('api_keys.secret'))
            ->post('https://api.paystack.co/transaction/initialize', $payload);
        if (! $response->ok() || !($response['status'] ?? false)) {
            throw new \RuntimeException('Paystack error: ' . ($response['message'] ?? 'Unknown'));
        }

        return new PaymentResponseDTO(
            gateway: 'paystack',
            reference: $response['data']['reference'],
            status: PaymentStatus::PENDING,
            redirectUrl: $response['data']['authorization_url'],
            raw: $response->json(),
        );
    }

    public function cancel(string $reference): bool
    {
        // Paystack ne prend pas en charge l'annulation via API pour les paiements en attente ou en cours
        return false;
    }

    public function refund(RefundRequestDTO $dto): RefundResponseDTO
    {
        $payload = [
            'transaction' => $dto->reference,
            'amount' => $dto->amountCents,
        ];

        $response = Http::withToken($this->config('api_keys.secret'))
            ->post('https://api.paystack.co/refund', $payload);

        if (! $response->ok() || !($response['status'] ?? false)) {
            throw new \RuntimeException('Paystack refund error: ' . ($response['message'] ?? 'Unknown'));
        }

        return new RefundResponseDTO(
            gateway: 'paystack',
            reference: $response['data']['id'] ?? $dto->reference,
            status: PaymentStatus::REFUNDED,
            raw: $response->json(),
        );
    }

    public function handleWebhook(string $signatureHeader, array $payload): WebhookDTO
    {
        $secret = $this->config('api_keys.webhook_secret');
        $computed = hash_hmac('sha512', json_encode($payload), $secret);

        if (! hash_equals($computed, $signatureHeader)) {
            throw new InvalidWebhookSignature('Paystack signature mismatch');
        }

        $event = $payload['event'] ?? '';
        $object = $payload['data'] ?? [];

        $status = match ($event) {
            'charge.success' => PaymentStatus::COMPLETED,
            'charge.failed'  => PaymentStatus::FAILED,
            'refund.success' => PaymentStatus::REFUNDED,
            default          => PaymentStatus::PENDING,
        };

        return new WebhookDTO(
            gateway: 'paystack',
            reference: $object['reference'] ?? 'unknown',
            status: $status,
            raw: $payload,
        );
    }

    public function hasSuccessPayment(string $reference): bool
    {
        $response = Http::withToken($this->config('api_keys.secret'))->get("https://api.paystack.co/transaction/verify/{$reference}");

        if (! $response->ok() || !($response['status'] ?? false)) {
            return false;
        }

        return ($response['data']['status'] ?? '') === 'success';
    }

    /**
     * Convertir un montant dans une devise locale (ex: NGN) en Kobo (entier)
     */
    public function convertToKobo(int $amount, string $currency): int
    {
        // Les monnaies comme NGN, GHS utilisent des subdivisions (ex: Kobo)
        $zeroDecimalCurrencies = ['JPY', 'KRW']; // exemple
        $currency = strtoupper($currency);

        if (in_array($currency, $zeroDecimalCurrencies)) {
            return $amount;
        }

        return $amount * 100;
    }
}
