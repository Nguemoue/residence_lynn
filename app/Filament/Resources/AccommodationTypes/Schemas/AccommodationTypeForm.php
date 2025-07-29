<?php

namespace App\Filament\Resources\AccommodationTypes\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AccommodationTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description')
                    ->required(),
                TextInput::make('price_per_night')
                    ->required()
                    ->numeric(),
                Toggle::make('is_available')
                    ->required(),
            ]);
    }
}
