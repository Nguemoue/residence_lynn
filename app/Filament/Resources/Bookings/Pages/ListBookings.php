<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make('Toutes'),
            'pending' => Tab::make('En cours')->modifyQueryUsing(fn($query) => $query->pending()),
            'approved' => Tab::make('Approuves')->modifyQueryUsing(fn($query) => $query->approved()),
            'canceled' => Tab::make('Annulées')->modifyQueryUsing(fn($query) => $query->canceled()),
        ];
    }
}
