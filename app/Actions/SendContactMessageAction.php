<?php
declare(strict_types=1);

namespace App\Actions;

use App\DTO\ContactMessageDto;
use App\Models\Contact;

final class SendContactMessageAction
{
    public function execute(ContactMessageDto $dto): void
    {
        Contact::create((array) $dto);
    }
}
