<?php

use App\Livewire\ChatBox;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ChatBox::class)
        ->assertStatus(200);
});
