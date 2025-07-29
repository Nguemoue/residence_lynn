<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('surname'),
                TextInput::make('role')->required(),
                FileUpload::make('photo')
                    ->disk('public')
                    ->directory('teams')
                ->image()
                ->imageEditor()
                ->imageCropAspectRatio('1:1'),
            ])->columns(1);
    }
}
