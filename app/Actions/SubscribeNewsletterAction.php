<?php
declare(strict_types=1);

namespace App\Actions;

use App\DTO\NewsletterSubscriptionDto;
use App\Models\Subscriber;

final class SubscribeNewsletterAction
{
    public function execute(NewsletterSubscriptionDto $dto): void
    {
        Subscriber::create([
            'email'         => $dto->email,
            'subscribed_at' => now(),
        ]);
    }
}
