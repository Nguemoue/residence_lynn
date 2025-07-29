<?php

namespace App\Filament\Resources\AccommodationTypes\Pages;

use App\Filament\Resources\AccommodationTypes\AccommodationTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAccommodationType extends EditRecord
{
    protected static string $resource = AccommodationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
