<?php
declare(strict_types=1);

use App\Actions\SendContactMessageAction;
use App\DTO\ContactMessageDto;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('stores contact message', function () {
    $dto = new ContactMessageDto(
        name:'Jane Doe',
        email:'jane@doe.com',
        subject:'Question',
        message:'Hello!'
    );

    /** @var SendContactMessageAction $action */
    $action = app(SendContactMessageAction::class);
    $action->execute($dto);

    expect(Contact::whereEmail('jane@doe.com')->exists())->toBeTrue();
});
