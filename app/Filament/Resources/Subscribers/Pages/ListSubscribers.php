<?php

namespace App\Filament\Resources\Subscribers\Pages;

use App\Filament\Actions\NewsLetter\SendGlobalMessageAction;
use App\Filament\Resources\Subscribers\SubscriberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubscribers extends ListRecords
{
    protected static string $resource = SubscriberResource::class;

    /**
     * @return string|null
     */
    public  function getTitle(): \Illuminate\Contracts\Support\Htmlable|string
    {
        return __('menu.subscribers');
    }
    protected function getHeaderActions(): array
    {
        return [
            SendGlobalMessageAction::make()
        ];
    }
}
