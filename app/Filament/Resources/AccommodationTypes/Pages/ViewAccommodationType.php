<?php

namespace App\Filament\Resources\AccommodationTypes\Pages;

use App\Filament\Resources\AccommodationTypes\AccommodationTypeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAccommodationType extends ViewRecord
{
    protected static string $resource = AccommodationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
