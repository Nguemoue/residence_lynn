<?php
declare(strict_types=1);

use App\Actions\SubscribeNewsletterAction;
use App\DTO\NewsletterSubscriptionDto;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('stores a newsletter subscription', function () {
    $dto = new NewsletterSubscriptionDto('test@demo.com');

    /** @var SubscribeNewsletterAction $action */
    $action = app(SubscribeNewsletterAction::class);
    $action->execute($dto);

    expect(Subscriber::whereEmail('test@demo.com')->exists())->toBeTrue();
});
