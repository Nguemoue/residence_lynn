<?php

declare(strict_types=1);

namespace App\Payments\Exceptions;

class NotSupportedCurrencyException extends \RuntimeException {

    public function __construct(string $currency,string $provider) {
        parent::__construct(message: "the given currency $currency is not supported by this provider [$provider]");
    }
}
