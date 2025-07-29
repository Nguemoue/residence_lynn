<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')->required()->columnSpanFull()->label("Question"),
                RichEditor::make('answer')->required()->columnSpanFull()->label("Reponse")->minLength(2),
                Toggle::make('is_active')->required()->label("Actif ?"),
            ]);
    }
}
