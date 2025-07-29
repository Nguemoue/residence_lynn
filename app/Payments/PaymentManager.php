<?php

declare(strict_types=1);

namespace App\Payments;

use App\Payments\Contracts\PaymentGatewayInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;

class PaymentManager
{
    public function gateway(?string $driver = null): PaymentGatewayInterface
    {
        $driver ??= config('payment.default');
        $map = config('payment.gateways');

        if (! isset($map[$driver])) {
            throw new \InvalidArgumentException("Unknown payment driver [$driver]");
        }

        $gateway = app($map[$driver]);

        if (! $gateway instanceof PaymentGatewayInterface) {
            throw new BindingResolutionException("$driver is not a valid gateway");
        }

        return $gateway;
    }

    /** Shortcut magic for `Payment::stripe()->createPayment()` */
    public function __call(string $method, array $args)
    {
        if (isset(config('payment.gateways')[$method])) {
            return $this->gateway($method);
        }

        throw new \BadMethodCallException("Method $method does not exist");
    }
}
