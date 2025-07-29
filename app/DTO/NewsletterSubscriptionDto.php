<?php
declare(strict_types=1);

namespace App\DTO;

final readonly class NewsletterSubscriptionDto
{
    public function __construct(
        public string $email,
    ) {}
}
