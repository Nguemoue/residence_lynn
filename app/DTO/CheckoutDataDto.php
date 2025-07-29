<?php
declare(strict_types=1);

namespace App\DTO;

final readonly class CheckoutDataDto
{
    public function __construct(
        public string $email,
        public string $phone,
        public string $fullName,
        public string $addressLine1,
        public string $city,
        public string $postalCode,
        public string $country = 'FR',
    ) {}
}
