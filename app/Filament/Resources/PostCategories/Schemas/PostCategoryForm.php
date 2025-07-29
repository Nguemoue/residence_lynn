<?php

namespace App\Filament\Resources\PostCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->afterStateUpdatedJs(<<<'JS'
$set('slug',$state?.replaceAll(' ','-').toLowerCase()??'')
JS)
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('slug')->required()->columnSpanFull(),
            ]);
    }
}
