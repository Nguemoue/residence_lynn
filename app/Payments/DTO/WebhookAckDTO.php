<?php

declare(strict_types=1);

namespace App\Payments\DTO;

final readonly class WebhookAckDTO
{
    public function __construct(public bool $ack = true) {}
}
