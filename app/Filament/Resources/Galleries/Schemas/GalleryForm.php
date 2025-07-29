<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')
                    ->label('Nom')
                    ->required()
                    ->maxLength(255)->columnSpanFull(),
                FileUpload::make('image')->disk('public')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
