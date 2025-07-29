<?php

declare(strict_types=1);

namespace App\Payments\DTO;

use App\Payments\Enums\PaymentStatus;

final readonly class WebhookDTO
{
    public function __construct(
        public string        $gateway,
        public string        $reference,
        public PaymentStatus $status,
        public array         $raw = [],
    ) {}
}
