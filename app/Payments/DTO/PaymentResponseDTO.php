<?php

declare(strict_types=1);

namespace App\Payments\DTO;

use App\Payments\Enums\PaymentStatus;

final readonly class PaymentResponseDTO
{
    public function __construct(
        public string        $gateway,      // ex : stripe
        public string        $reference,    // ID provider
        public PaymentStatus $status,
        public ?string       $redirectUrl = null,
        public array         $raw = [],
    ) {}
}
