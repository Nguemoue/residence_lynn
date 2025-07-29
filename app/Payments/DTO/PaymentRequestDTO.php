<?php

declare(strict_types=1);

namespace App\Payments\DTO;


use App\Payments\Enums\Currency;

final readonly class PaymentRequestDTO
{
    public function __construct(
        public string  $reference,     // UUID interne
        public int     $amountCents,   // stocké en centimes
        public Currency $currency,
        public string  $description,
        public array   $metadata = [],
        public ?string $returnUrl = null,
        public ?string $cancelUrl = null,
    ) {}
}
