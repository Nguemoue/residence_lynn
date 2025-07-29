<?php

declare(strict_types=1);

namespace App\Payments\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Payments\Contracts\PaymentGatewayInterface gateway(?string $driver = null)
 */
class Payment extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'payment';
    }
}
