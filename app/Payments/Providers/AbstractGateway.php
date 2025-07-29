<?php

declare(strict_types=1);

namespace App\Payments\Providers;

use App\Actions\CheckoutAction;
use App\Domain\Services\CheckoutService;
use App\DTO\CheckoutDataDto;
use App\Events\Payment\OrderCreateEvent;
use App\Models\OrderPaymentRequest;
use App\Payments\Contracts\PaymentGatewayInterface;
use App\Payments\Exceptions\NotSupportedCurrencyException;
use App\Payments\Traits\ConvertsAmounts;
use Illuminate\Support\Arr;

abstract class AbstractGateway implements PaymentGatewayInterface
{
    use ConvertsAmounts;

    /** Simplifie l’accès à la config provider */
    protected function config(string $key, $default = null)
    {
        return config("payment.{$this->getName()}.{$key}", $default);
    }

    /** Nom court du provider (ex : stripe) */
    abstract public function getName(): string;


    public function validateCurrency(string $currency): void
    {
        $allowedCurrencies = (array) $this->config('config.currencies');
        if(! in_array($currency,$allowedCurrencies ,true)){
            throw  new NotSupportedCurrencyException(currency: $currency,provider: $this->getName());

        }
    }
     public function getSupportedCurrencies(): array{
        return $this->config('config.currencies');
    }
     public function getFallbackCurrency(): string{
        return $this->config('config.fallback_currency');
    }
    public function handleSuccessCheckout(string $reference): void
    {
        //get the order request
        $orderRequest = OrderPaymentRequest::query()->firstWhere('payment_reference', $reference);
        if ($orderRequest === null) {
            return;
        }
        $order = app(CheckoutAction::class)->execute(
            new CheckoutDataDto(
                email: $orderRequest->payer_email,
                phone: $orderRequest->payer_phone,
                fullName: $orderRequest->payer_name . ' ' . $orderRequest->payer_name,
                addressLine1: $orderRequest->payer_address,
                city: $orderRequest->payer_city,
                postalCode: $orderRequest->payer_postal_code,
            )
        );
        $order->update(['order_payment_request_id' => $orderRequest->id]);
        event(new OrderCreateEvent(reference: $reference,order: $order));
    }
    public function convertAmountToCurrency(string $from, float|int $amount, string $to): float|int
    {
        if ($from === $to) {
            return  $amount;
        }

        $rate = config("payment.conversion_rates.{$from}.{$to}");

        if ($rate) {
             return round($amount * $rate);
        }

        throw new \RuntimeException("Cannot convert currency from {$from} to {$to}.");
    }
}
