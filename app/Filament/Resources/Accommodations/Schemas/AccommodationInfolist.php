<?php

namespace App\Filament\Resources\Accommodations\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AccommodationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('accommodation_type_id')
                    ->numeric(),
                TextEntry::make('price')
                    ->money(),
                ImageEntry::make('cover_image'),
                IconEntry::make('is_available')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
