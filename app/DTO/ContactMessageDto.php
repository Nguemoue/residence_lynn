<?php
declare(strict_types=1);

namespace App\DTO;

final readonly class ContactMessageDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $subject,
        public string $message,
    ) {}
}
