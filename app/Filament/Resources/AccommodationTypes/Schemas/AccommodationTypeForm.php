<?php

namespace App\Filament\Resources\AccommodationTypes\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class AccommodationTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('price_per_night')->numeric()->required()->prefix(defaultCurrency()),
                ])->columnSpanFull(),

                CheckboxList::make('services')->relationship('services', 'name')->columns(4)->columnSpanFull(),
                RichEditor::make('description')->required()->columnSpanFull(),
                TagsInput::make('amenities')->columnSpanFull(),
                FileUpload::make('gallery')->image()->multiple()->required()->columnSpanFull()->columns(2),
            ]);
    }
}
