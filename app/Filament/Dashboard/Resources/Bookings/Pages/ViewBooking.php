<?php

namespace App\Filament\Dashboard\Resources\Bookings\Pages;

use App\Filament\Dashboard\Resources\Bookings\BookingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
