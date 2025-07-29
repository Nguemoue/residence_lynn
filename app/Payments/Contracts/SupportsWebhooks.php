<?php

declare(strict_types=1);

namespace App\Payments\Contracts;

use App\Payments\DTO\WebhookDTO;

interface SupportsWebhooks
{
    /**
     * @throws \App\Payments\Exceptions\InvalidWebhookSignature
     */
    public function handleWebhook(string $signatureHeader, array $payload): WebhookDTO;
}
