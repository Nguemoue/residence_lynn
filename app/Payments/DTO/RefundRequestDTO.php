<?php

declare(strict_types=1);

namespace App\Payments\DTO;

final readonly class RefundRequestDTO
{
    public function __construct(
        public string $reference,    // id transaction provider
        public ?int   $amountCents = null,  // null = total
        public array  $metadata = [],
    ) {}
}
